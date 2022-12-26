<?php

    function checkStatus($items)
    {
        foreach ($items as $item) {
            if (!$item['status']) {
                return false;
            }
        }

        return true;
    }
