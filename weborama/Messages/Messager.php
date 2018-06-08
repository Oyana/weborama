<?php

namespace Weborama\Messages;

class Messager
{
    public static $messages = [];

    public static function add($type, $datas)
    {
        self::$messages[] = new Message($type, $datas);
    }

    public static function render($type = null)
    {
        $datas = [];
        $messages = self::getMessagesByType($type);
        foreach ($messages as $message) {
            $datas[] = $message->data;
        }

        return $datas;
    }

    private static function getMessagesByType($type = null)
    {
        if ($type == null) {
            return self::$messages;
        }

        $messages = [];
        foreach (self::$messages as $message) {
            if ($message->type == $type) {
                $messages[] = $message;
            }
        }

        return $messages;
    }
}
