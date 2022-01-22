<?php
Settings::SaveSettingsVar("Services::SyncDisplays--start",date("H:i:s"));
SyncDisplays::Sync();
Settings::SaveSettingsVar("Services::SyncDisplays--done",date("H:i:s"));
?>