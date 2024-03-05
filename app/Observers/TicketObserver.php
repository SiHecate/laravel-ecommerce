<?php

namespace App\Observers;

use App\Models\Inbox;

class TicketObserver
{

    /*
        Yeni bir ticket oluşturulduğunda oluşturulan user_id'den alınan
        veriye göre kullanıcıya notification yollanacak.
    */

    public function created(Inbox $inbox): void
    {
    }

    public function updated(Inbox $inbox): void
    {
    }

    public function deleted(Inbox $inbox): void
    {
    }

    public function restored(Inbox $inbox): void
    {
    }

    public function forceDeleted(Inbox $inbox): void
    {
    }
}
