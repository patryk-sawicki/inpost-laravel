<?php

namespace PatrykSawicki\InPost\app\Classes;

class InPost
{
    public static function services(): Services {
        return new Services();
    }

    public static function organizations(): Organizations {
        return new Organizations();
    }

    public static function shipment(): Shipment {
        return new Shipment();
    }

    public static function points(): Points {
        return new Points();
    }

    public static function tracking(): Tracking {
        return new Tracking();
    }

    public static function statuses(): Statuses {
        return new Statuses();
    }

    public static function dispatchOrders(): DispatchOrders {
        return new DispatchOrders();
    }
}