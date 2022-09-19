<?php
//Settings::SaveSettingsVar("Services::SyncDisplays--start",date("H:i:s"));
Services::Start("NullDisplay::EveryMinute");
Services::Log("NullDisplay::EveryMinute","SyncDisplays::Sync");
SyncDisplays::Sync();
Services::Complete("NullDisplay::EveryMinute");
//Settings::SaveSettingsVar("Services::SyncDisplays--done",date("H:i:s"));
?>