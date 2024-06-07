<?php

class AgentDashboardController
{
    public function show()
    {
        $url = $_SERVER['REQUEST_URI'];
        $queryUrl = parse_url($url);
        if (strpos($url, 'agent/uuid/luma') !== false) {
            require_once 'website/agent/dash_agent.php';
        }else if (strpos($url, 'agent/uuid/minecraft') !== false) {
            require_once 'website/agent/dash_agent_minecraft.php';
        }else{
            require_once 'website/agent/dashboard.php';
        }
        
    }
}
