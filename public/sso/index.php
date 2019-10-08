<?php

header("Location: /backend/ssoSuccess?code=" . $_GET["code"] . "&state=" . $_GET["state"]);
die();