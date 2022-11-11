<?php

namespace App\Traits;

use Brian2694\Toastr\Facades\Toastr;

trait ToastNotification
{
    public function toastSuccess($message, $title)
    {
        return Toastr::success($message, $title, [
            "positionClass" => "toast-top-right",
            "closeButton" => true,
            "progressBar" => true,
            "preventDuplicates" => true,
            "newestOnTop" => true,
            "timeOut" => "3000",
        ]);
    }

    public function toastWarning($message, $title)
    {
        return Toastr::warning($message, $title, [
            "positionClass" => "toast-top-right",
            "closeButton" => true,
            "progressBar" => true,
            "preventDuplicates" => true,
            "newestOnTop" => true,
            "timeOut" => "3000",
        ]);
    }

    public function toastError($message, $title)
    {
        return Toastr::error($message, $title, [
            "positionClass" => "toast-top-right",
            "closeButton" => true,
            "progressBar" => true,
            "preventDuplicates" => true,
            "newestOnTop" => true,
            "timeOut" => "3000",
        ]);
    }
}
