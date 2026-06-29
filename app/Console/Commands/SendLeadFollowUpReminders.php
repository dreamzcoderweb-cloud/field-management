<?php

namespace App\Console\Commands;

use App\Classes\PushHelper;
use App\Models\Lead;
use App\Models\Notificaion as Notification;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class SendLeadFollowUpReminders extends Command
{
    protected $signature = 'leads:send-follow-up-reminders
        {--date= : Base date for reminders in Y-m-d format}
        {--type= : Send only one reminder type: today or tomorrow}';

    protected $description = 'Send Firebase push reminders for lead follow-up dates.';

    public function handle(PushHelper $pushHelper): int
    {
        $baseDate = $this->option('date')
            ? Carbon::parse($this->option('date'))->startOfDay()
            : now()->startOfDay();

        $requestedType = $this->option('type');
        $reminderTypes = $requestedType ? [$requestedType] : ['tomorrow', 'today'];

        if (count(array_diff($reminderTypes, ['today', 'tomorrow'])) > 0) {
            $this->error('Invalid reminder type. Use today or tomorrow.');

            return self::FAILURE;
        }

        $sent = 0;
        $storedOnly = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($reminderTypes as $reminderType) {
            $targetDate = $reminderType === 'tomorrow'
                ? $baseDate->copy()->addDay()
                : $baseDate->copy();

            Lead::with(['product', 'user'])
                ->whereNotNull('user_id')
                ->whereDate('follow_up_date', $targetDate)
                ->chunkById(100, function ($leads) use ($pushHelper, $reminderType, $targetDate, &$sent, &$storedOnly, &$skipped, &$failed) {
                    foreach ($leads as $lead) {
                        [$title, $message] = $this->buildReminderMessage($lead, $reminderType, $targetDate);

                        if ($this->alreadySentToday($lead->user_id, $title, $message)) {
                            $skipped++;
                            continue;
                        }

                        try {
                            $wasPushed = $pushHelper->sendLeadFollowUpReminder(
                                $lead->user_id,
                                $title,
                                $message,
                                $lead->id,
                                $reminderType
                            );

                            $wasPushed ? $sent++ : $storedOnly++;
                        } catch (\Throwable $exception) {
                            $failed++;

                            Log::warning('Lead follow-up push reminder failed.', [
                                'lead_id' => $lead->id,
                                'user_id' => $lead->user_id,
                                'reminder_type' => $reminderType,
                                'error' => $exception->getMessage(),
                            ]);
                        }
                    }
                });
        }

        $this->info("Lead follow-up reminders completed. Pushed: {$sent}, stored only: {$storedOnly}, skipped: {$skipped}, failed: {$failed}.");

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }

    private function buildReminderMessage(Lead $lead, string $reminderType, Carbon $targetDate): array
    {
        $date = $targetDate->format('d-m-Y');
        $product = $lead->product?->name ? " Product: {$lead->product->name}." : '';

        if ($reminderType === 'tomorrow') {
            return [
                'Lead follow-up tomorrow',
                "Follow up with {$lead->name} ({$lead->mobile}) tomorrow, {$date}.{$product}",
            ];
        }

        return [
            'Lead follow-up today',
            "Follow up with {$lead->name} ({$lead->mobile}) today, {$date}.{$product}",
        ];
    }

    private function alreadySentToday(int $userId, string $title, string $message): bool
    {
        return Notification::where('to_user_id', $userId)
            ->where('type', 'user')
            ->where('title', $title)
            ->where('description', $message)
            ->whereDate('created_at', now())
            ->exists();
    }
}
