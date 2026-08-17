<?php
/**
 * ------------------------------------------------------------------------
 * JA Spa Template
 * ------------------------------------------------------------------------
 * Copyright (C) 2004-2011 J.O.O.M Solutions Co., Ltd. All Rights Reserved.
 * @license - Copyrighted Commercial Software
 * Author: J.O.O.M Solutions Co., Ltd
 * Websites:  http://www.joomlart.com -  http://www.joomlancers.com
 * This file may not be redistributed in whole or significant part.
 * ------------------------------------------------------------------------
*/
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;

defined('_JEXEC') or die;
$count = count($list);
?>
<div class="view-latest-grid<?php echo $params->get ('moduleclass_sfx') ?>">
	<div class="row">
		<?php $i=0; foreach ($list as $item) :  ?>
			<div class="col-sm-12 col-md-12 col-lg-4 item-latest">
				<div class="content-article">
					<div class="wrap-info d-flex justify-content-center">
						<div class="date">			
							<?php echo Text::sprintf(HTMLHelper::_('date', $item->publish_up, Text::_('Y.d.m'))); ?>
						</div>
					</div>

					<div class="title-article">
						<h3>
							<a class="heading-link" href="<?php echo $item->link; ?>">
								<?php echo $item->title; ?>
							</a>
						</h3>
					</div>

					<div class="desc-article">
						<?php echo $item->introtext;?>
					</div>

					<div class="readmore">
						<a class="readmore-link" href="<?php echo $item->link; ?>">View More</a>
					</div>
				</div>
			</div>
		<?php $i++; endforeach; ?>
	</div>
</div>

<style>
.view-latest-grid {
	text-align: center;
}

.view-latest-grid .item-latest {
	padding-left: 36px;
	padding-right: 36px;
	margin-bottom: 36px;
}

.view-latest-grid .item-latest + .item-latest {
	border-top: 1px solid #f4f4f4;
	border-left: 0;
	padding-top: 36px;
}

.view-latest-grid .wrap-info {
	font-family: Marcellus;
	font-style: normal;
	font-weight: normal;
	font-size: 16px;
	line-height: 1.62;
	text-align: center;
	text-transform: uppercase;
	color: #828282;
}

.view-latest-grid .title-article h3 {
	font-family: Marcellus;
	font-style: normal;
	font-weight: normal;
	font-size: 24px;
	line-height: 1.33;
	text-align: center;
	text-transform: capitalize;
	color: #151515;
	margin-bottom: 32px;
}

.view-latest-grid .title-article .heading-link {
	color: #151515;
} 

.view-latest-grid .readmore .readmore-link {
	font-family: Marcellus;
	font-style: normal;
	font-weight: normal;
	font-size: 14px;
	line-height: 1.86;
	text-transform: uppercase;
	color: #151515;
}

.view-latest-grid .readmore .readmore-link:hover {
	color: #D37B4A;
}

@media (min-width: 992px) {
	.view-latest-grid .item-latest {
		margin-bottom: 0;
	}

	.view-latest-grid .item-latest + .item-latest {
		border-left: 1px solid #f4f4f4;
		border-top: 0;
		padding-top: 0;
	}
}
</style>