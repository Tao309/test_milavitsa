<?php

namespace App\Observers;

use App\Mail\EmailSender;
use App\models\Issue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Mockery\Exception;

class IssueObserver
{
    /**
     * Handle the issue "created" event.
     *
     * @param  \App\models\Issue  $issue
     * @return void
     */
    public function created(Issue $issue)
    {
        //
    }

    /**
     * Handle the issue "updated" event.
     *
     * @param  \App\models\Issue  $issue
     * @return void
     */
    public function updated(Issue $issue)
    {
        $mailObject =  null;

        if(!empty($issue->manager))
        {
            /**
             * Отправка письма менеджеру, если клиент закрыл задачу сам
             */
            if(
                $issue->closed > $issue->getOriginal('closed')
                && Auth::user()->id == $issue->author->id
            )
            {
                $mailObject = new \stdClass();
                $mailObject->sender = 'Test App';
                $mailObject->receiver = $issue->manager->email;
                $mailObject->message = "Owner {$issue->author->name} close own issue #{$issue->id}";
            }

            /**
             * Отправка письма при ответе на заявку
             */
            if(!empty($issue->answer))
            {
                $mailObject = new \stdClass();
                $mailObject->sender = 'Test App';
                $mailObject->receiver = $issue->author->email;
                $mailObject->message = "You have answer for own issue";
            }
        }



        if(!empty($mailObject))
        {
            try {
                Mail::to($mailObject->receiver)->send(new EmailSender($mailObject));
            } catch(\Swift_TransportException $e)
            {

            }
        }
    }

    /**
     * Handle the issue "deleted" event.
     *
     * @param  \App\models\Issue  $issue
     * @return void
     */
    public function deleted(Issue $issue)
    {
        //
    }

    /**
     * Handle the issue "restored" event.
     *
     * @param  \App\models\Issue  $issue
     * @return void
     */
    public function restored(Issue $issue)
    {
        //
    }

    /**
     * Handle the issue "force deleted" event.
     *
     * @param  \App\models\Issue  $issue
     * @return void
     */
    public function forceDeleted(Issue $issue)
    {
        //
    }
}
