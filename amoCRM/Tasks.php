<?php

namespace amoCRM;

/**
 * @method \amoCRM\Tasks add(\amoCRM\Task $task) Description
 */

class Tasks extends Collection {
    
    use UpdatedCollection;
    
    /**
     * 
     * @return \amoCRM\Task
     */
    public function createTask() {
        $task = new Task();
        $this->add($task);
        return $task;
    }
    
}