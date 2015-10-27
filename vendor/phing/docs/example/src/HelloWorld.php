<?php

    /**
     * The Hello World class!
     *
     * @author Michiel Rook
     * @version $Id: 6d0faa2d895d9326430e447bdef12f4815068a42 $
     * @package hello.world
     */
    class HelloWorld
    {
        public function foo($silent = true)
        {
            if ($silent) {
                return;
            }

            return 'foo';
        }

        public function sayHello()
        {
            return "Hello World!";
        }
    };
