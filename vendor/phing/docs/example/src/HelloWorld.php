<?php

    /**
     * The Hello World class!
     *
     * @author Michiel Rook
     * @version $Id: 2426f17cfc5bfcce69c158b5ae4efdb87bfd9a58 $
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
