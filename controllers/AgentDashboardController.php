<?php

class AgentDashboardController
{
    public function show()
    {
        $url = $_SERVER['REQUEST_URI'];
        $queryUrl = parse_url($url);
        if (strpos($url, 'agent/uuid') !== false) {
            require_once 'website/agent/dash_agent.php';
        }else{
            require_once 'website/agent/dashboard.php';
        }
        
    }
}
