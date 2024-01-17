<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\WomenAccountCompletion;
use App\Models\Notification;
use App\Mail\WeeklyNotification;
use Illuminate\Support\Facades\Mail;

class NotificationController extends Controller
{
    public function sendNotifications()
    {
        $women = WomenAccountCompletion::all();

        foreach ($women as $woman) {
            $currentWeek = $this->calculateCurrentWeek($woman->conceivedate, $woman->expectedDuedatedeliverbaby);
            $notificationMessage = $this->getNotificationMessage($currentWeek);

            Notification::create([
                'user_id' => $woman->id,
                'message' => $notificationMessage,
            ]);

            // Send email notification
            Mail::to($woman->email)->send(new WeeklyNotification($notificationMessage));
        }

        return response()->json(['message' => 'Notifications sent successfully'], 200);
    }

    private function calculateCurrentWeek($conceivedate, $expectedDueDate)
    {
        // Logic to calculate the current pregnancy week based on dates
        // You may use Carbon or other date manipulation libraries here
        // Sample logic (requires Carbon): 
        $conceiveDate = \Carbon\Carbon::parse($conceivedate);
        $currentDate = \Carbon\Carbon::now();
        $currentWeek = $currentDate->diffInWeeks($conceiveDate);

        return $currentWeek;
    }

    private function getNotificationMessage($currentWeek)
    {
        // Logic to get the notification message based on the current pregnancy week
        // Use the provided example messages or customize as needed
        $messages = [
            'Week 1: Congratulations on your pregnancy! This week, your baby is about the size of a sesame seed. Focus on healthy eating and prenatal vitamins.',
            'Week 2: Your baby\'s heart is starting to beat! You might experience fatigue and nausea this week. Drink plenty of fluids and get enough rest.',
            'Week 3: Your baby\'s neural tube is developing. Ensure adequate folic acid intake through food or supplements.',
            'Week 4: Your baby is about the size of a raspberry! Avoid alcohol, smoking, and certain medications. Start gentle exercise if you haven\'t already.',
            'Week 5: Your baby\'s arms and legs are forming. Listen to your body and rest when needed.',
            'Week 6: You might experience morning sickness more intensely this week. Eat small, frequent meals and choose bland foods.',
            'Week 7: Your baby\'s eyes and ears are starting to develop. Avoid exposure to harmful chemicals and toxins.',
            'Week 8: Your baby\'s skeleton is starting to harden. Eat calcium-rich foods like dairy products and leafy greens.',
            'Week 9: You might start to feel your baby move! This is a normal and exciting development.',
            'Week 10: Your baby is about the size of a lime! Your appetite might increase, so listen to your body\'s hunger cues. Consider having your membranes swept at your doctor\'s appointment. This procedure can sometimes help induce labor, but consult your doctor for potential risks and benefits. Be patient and trust your body\'s natural timing. Every pregnancy is unique, and your baby will arrive when it\'s ready.',
        ];
        

        return $messages[$currentWeek - 1] ?? 'Congratulations on your pregnancy!';
    }
}
