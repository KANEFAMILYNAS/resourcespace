<?php

$suppress_headers = true;

include "../../include/db.php";
include "../../include/general.php";
include "../../include/authenticate.php";

$ref = getvalescaped('ref', 0, true);
$extension = getvalescaped('ext', 'jpg');

if ($ref == 0 || $extension == 'php')
	{
	http_response_code(403);
	exit;
	}

$size = getvalescaped('size', '');
$alternative = getvalescaped('alternative', -1, true);
$watermark = getvalescaped('watermark', false);
$page = getvalescaped('page', 1, true);

$path = get_resource_path($ref, true, $size, false, $extension, -1, $page, $watermark, "",
		$alternative, true);

if (!is_readable($path))
	{
	http_response_code(404);
	exit;
	}

$filename = basename($path);
$filename = substr($filename, 0, strpos($filename, '_')) . '.' . $extension;

header('Content-Transfer-Encoding: binary');
header('Content-Type: ' . get_mime_type($path, $extension));
header('Content-Length: ' . filesize($path));

ob_end_flush();
readfile($path);