<?php

namespace Weborama\Messages;

class Messager
{
    public static $messages = [];

    /**
     * Add a new message
     */
    public static function add($type, $datas)
    {
        self::$messages[] = new Message($type, $datas);
    }

    /**
     * Return messages datas by types
     */
    public static function render($type = null)
    {
        $datas = [];
        $messages = self::getMessagesByType($type);
        foreach ($messages as $message) {
            $datas[] = $message->data;
        }

        return $datas;
    }

    /**
     * Get messages by their types
     */
    private static function getMessagesByType($type = null)
    {
        if ($type == null) {
            return self::$messages;
        }

        return array_filter(
            self::$messages,
            function ($message) use ($type) {
                return $message->type === $type;
            }
        );
    }

    /**
     * Fill the messager with messages in session and empty this session.
     */
    public static function loadSessionMessages()
    {
        if (isset($_SESSION['messages'])) {
            self::$messages = $_SESSION['messages'];
            unset($_SESSION['messages']);
        }
    }
}
