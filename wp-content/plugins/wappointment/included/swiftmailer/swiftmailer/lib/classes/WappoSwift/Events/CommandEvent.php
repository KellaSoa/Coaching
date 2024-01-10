<?php

/*
 * This file is part of SwiftMailer.
 * (c) 2004-2009 Chris Corbyn
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Generated when a command is sent over an SMTP connection.
 *
 * @author Chris Corbyn
 */
class WappoSwift_Events_CommandEvent extends WappoSwift_Events_EventObject
{
    /**
     * The command sent to the server.
     *
     * @var string
     */
    private $command;

    /**
     * An array of codes which a successful response will contain.
     *
     * @var int[]
     */
    private $successCodes = [];

    /**
     * Create a new CommandEvent for $source with $command.
     *
     * @param string $command
     * @param array  $successCodes
     */
    public function __construct(WappoSwift_Transport $source, $command, $successCodes = [])
    {
        parent::__construct($source);
        $this->command = $command;
        $this->successCodes = $successCodes;
    }

    /**
     * Get the command which was sent to the server.
     *
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * Get the numeric response codes which indicate success for this command.
     *
     * @return int[]
     */
    public function getSuccessCodes()
    {
        return $this->successCodes;
    }
}
