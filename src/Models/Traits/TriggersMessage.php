<?php

namespace Wizclumsy\Utils\Models\Traits;

use Illuminate\Support\Facades\Mail;

trait TriggersMessage
{
    public static function bootTriggersMessage()
    {
        self::created(function ($model) {

            if (!count($model->getRecipients('to')) || !$model->shouldSendMessage()) {
                return;
            }

            $model->mailMessage();
            $model->mailAcknowledge();
        });
    }

    public function originatorEmail()
    {
        return $this->email;
    }

    public function originatorName()
    {
        return $this->name;
    }

    public function shouldSendMessage()
    {
        return request()->method() === 'POST';
    }

    public function getRecipients($type)
    {
        if (app()->environment() !== 'production') {
            return $type === 'to' ? (array)$this->getDevelopmentRecipient() : [];
        }

        $dynamicMethod = 'getRecipients'.studly_case($type);
        if (method_exists($this, $dynamicMethod)) {
            return (array)$this->{$dynamicMethod}();
        }

        return property_exists($this, $type) ? (array)$this->{$type} : [];
    }

    public function getDevelopmentRecipient()
    {
        return property_exists($this, 'developmentRecipient') ? $this->developmentRecipient : null;
    }

    public function getViewSlug()
    {
        return str_replace('_', '-', snake_case(class_basename($this)));
    }

    public function messageView()
    {
        $slug = $this->getViewSlug();
        return property_exists($this, 'messageView') ? $this->messageView : "emails.{$slug}";
    }

    public function acknowledgeView()
    {
        $slug = $this->getViewSlug();
        return property_exists($this, 'acknowledgeView') ? $this->acknowledgeView : "emails.acknowledge-{$slug}";
    }

    public function messageSubject()
    {
        return property_exists($this, 'messageSubject') ? $this->messageSubject : null;
    }

    public function acknowledgeSubject()
    {
        return property_exists($this, 'acknowledgeSubject') ? $this->acknowledgeSubject : null;
    }

    public function mailMessage()
    {
        Mail::send($this->messageView(), ['model' => $this], function ($message) {

            foreach (['to', 'cc', 'bcc'] as $method) {
                foreach ($this->getRecipients($method) as $address => $recipient) {
                    if (!$address) {
                        // Allow recipients to be non-associative array of addresses
                        $address = $recipient;
                    }

                    $message->{$method}($address, $recipient);
                }
            }

            $message->subject($this->messageSubject());
        });
    }

    public function mailAcknowledge()
    {
        Mail::send($this->acknowledgeView(), ['model' => $this], function ($message) {
            $message->to($this->originatorEmail(), $this->originatorName());
            $message->subject($this->acknowledgeSubject());
        });
    }
}
