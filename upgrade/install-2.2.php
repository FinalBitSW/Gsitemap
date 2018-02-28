<?php

/**
 * Copyright © 2017 FinalBit Solution. All rights reserved.
 * http://www.finalbit.ch
 * See LICENSE.txt for license details.
 */

if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_2_2($object, $install = false)
{
	if ($object->active || $install)
	{
		Configuration::updateValue('GSITEMAP_PRIORITY_HOME', 1.0);
		Configuration::updateValue('GSITEMAP_PRIORITY_PRODUCT', 0.9);
		Configuration::updateValue('GSITEMAP_PRIORITY_CATEGORY', 0.8);
		Configuration::updateValue('GSITEMAP_PRIORITY_MANUFACTURER', 0.7);
		Configuration::updateValue('GSITEMAP_PRIORITY_SUPPLIER', 0.6);
		Configuration::updateValue('GSITEMAP_PRIORITY_CMS', 0.5);
		Configuration::updateValue('GSITEMAP_FREQUENCY', 'weekly');
		Configuration::updateValue('GSITEMAP_LAST_EXPORT', false);

		return Db::getInstance()->Execute('DROP TABLE IF  EXISTS `'._DB_PREFIX_.'gsitemap_sitemap`') && Db::getInstance()->Execute('CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'gsitemap_sitemap` (`link` varchar(255) DEFAULT NULL, `id_shop` int(11) DEFAULT 0) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8;');
	}
	$object->upgrade_detail['2.2'][] = 'GSitemap upgrade error !';
	return false;
}