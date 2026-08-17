<?php
/**
 * @package DJ-Accessibility
 * @copyright Copyright (C) DJ-Extensions.com, All rights reserved.
 * @license http://www.gnu.org/licenses GNU/GPL
 * @author url: http://dj-extensions.com
 * @author email artur.kaczmarek@design-joomla.eu
 */

defined('_JEXEC') or die;

$style = ' djacc--' . DJAcc::getParam('style', 'dark');
$positionParam = DJAcc::getParam('position', 'sticky');
$position = ' djacc--' . $positionParam;
$alignParam = DJAcc::getParam('align_popup', 'top right');
$directionParam = DJAcc::getParam('direction', 'top left');
$align = ( 'custom' == $positionParam ) ? ' djacc--' . str_replace(' ', '-', $directionParam) : ' djacc--' . str_replace(' ', '-', $alignParam);
$customBtn = DJAcc::getParam('image', false);

?>
<section class="djacc djacc-container djacc-popup djacc--hidden<?php echo $style . $position . $align; ?>">
	<?php if( $customBtn ) { ?>
		<button class="djacc__openbtn djacc__openbtn--custom" aria-label="<?php echo JText::_('PLG_DJACCESSIBILITY_OPEN_BUTTON'); ?>" title="<?php echo JText::_('PLG_DJACCESSIBILITY_OPEN_BUTTON'); ?>">
			<img src="<?php echo $customBtn; ?>" alt="<?php echo JText::_('PLG_DJACCESSIBILITY_OPEN_BUTTON'); ?>">
		</button>
	<?php } else { ?>
		<button class="djacc__openbtn djacc__openbtn--default" aria-label="<?php echo JText::_('PLG_DJACCESSIBILITY_OPEN_BUTTON'); ?>" title="<?php echo JText::_('PLG_DJACCESSIBILITY_OPEN_BUTTON'); ?>">
			<svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48">
				<path d="M1480.443,27.01l-3.891-7.51-3.89,7.51a1,1,0,0,1-.89.54,1.073,1.073,0,0,1-.46-.11,1,1,0,0,1-.43-1.35l4.67-9V10.21l-8.81-2.34a1,1,0,1,1,.51-1.93l9.3,2.47,9.3-2.47a1,1,0,0,1,.509,1.93l-8.81,2.34V17.09l4.66,9a1,1,0,1,1-1.769.92ZM1473.583,3a3,3,0,1,1,3,3A3,3,0,0,1,1473.583,3Zm2,0a1,1,0,1,0,1-1A1,1,0,0,0,1475.583,3Z" transform="translate(-1453 10.217)" fill="#fff"/>
			</svg>
		</button>
	<?php } ?>
	<div class="djacc__panel">
		<div class="djacc__header">
			<p class="djacc__title"><?php echo JText::_('PLG_DJACCESSIBILITY_TITLE'); ?></p>
			<button class="djacc__reset" aria-label="<?php echo JText::_('PLG_DJACCESSIBILITY_RESET'); ?>" title="<?php echo JText::_('PLG_DJACCESSIBILITY_RESET'); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
					<path d="M9,18a.75.75,0,0,1,0-1.5,7.5,7.5,0,1,0,0-15A7.531,7.531,0,0,0,2.507,5.25H3.75a.75.75,0,0,1,0,1.5h-3A.75.75,0,0,1,0,6V3A.75.75,0,0,1,1.5,3V4.019A9.089,9.089,0,0,1,2.636,2.636,9,9,0,0,1,15.364,15.365,8.94,8.94,0,0,1,9,18Z" fill="#fff"/>
				</svg>
			</button>
			<button class="djacc__close" aria-label="<?php echo JText::_('PLG_DJACCESSIBILITY_CLOSE'); ?>" title="<?php echo JText::_('PLG_DJACCESSIBILITY_CLOSE'); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" width="14.828" height="14.828" viewBox="0 0 14.828 14.828">
					<g transform="translate(-1842.883 -1004.883)">
						<line x2="12" y2="12" transform="translate(1844.297 1006.297)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="2"/>
						<line x1="12" y2="12" transform="translate(1844.297 1006.297)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="2"/>
					</g>
				</svg>
			</button>
		</div>
		<ul class="djacc__list">
			<li class="djacc__item djacc__item--contrast">
				<button class="djacc__btn djacc__btn--invert-colors" title="<?php echo JText::_('PLG_DJACCESSIBILITY_INVERT_COLORS'); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
						<g fill="none" stroke="#fff" stroke-width="2">
							<circle cx="12" cy="12" r="12" stroke="none"/>
							<circle cx="12" cy="12" r="11" fill="none"/>
						</g>
						<path d="M0,12A12,12,0,0,1,12,0V24A12,12,0,0,1,0,12Z" fill="#fff"/>
					</svg>
					<span class="djacc_btn-label"><?php echo JText::_('PLG_DJACCESSIBILITY_INVERT_COLORS'); ?></span>
				</button>
			</li>
			<li class="djacc__item djacc__item--contrast">
				<button class="djacc__btn djacc__btn--monochrome" title="<?php echo JText::_('PLG_DJACCESSIBILITY_MONOCHROME'); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
						<g fill="none" stroke="#fff" stroke-width="2">
							<circle cx="12" cy="12" r="12" stroke="none"/>
							<circle cx="12" cy="12" r="11" fill="none"/>
						</g>
						<line y2="21" transform="translate(12 1.5)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="2"/>
						<path d="M5.853,7.267a12.041,12.041,0,0,1,1.625-1.2l6.3,6.3v2.829Z" transform="translate(-0.778 -4.278)" fill="#fff"/>
						<path d="M3.2,6.333A12.006,12.006,0,0,1,4.314,4.622l9.464,9.464v2.829Z" transform="translate(-0.778)" fill="#fff"/>
						<path d="M1.823,10.959a11.953,11.953,0,0,1,.45-2.378l11.506,11.5v2.829Z" transform="translate(-0.778)" fill="#fff"/>
					</svg>
					<span class="djacc_btn-label"><?php echo JText::_('PLG_DJACCESSIBILITY_MONOCHROME'); ?></span>
				</button>
			</li>
			<li class="djacc__item djacc__item--contrast">
				<button class="djacc__btn djacc__btn--dark-contrast" title="<?php echo JText::_('PLG_DJACCESSIBILITY_DARK_CONTRAST'); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
						<path d="M12,27A12,12,0,0,1,9.638,3.232a10,10,0,0,0,14.13,14.13A12,12,0,0,1,12,27Z" transform="translate(0 -3.232)" fill="#fff"/>
					</svg>
					<span class="djacc_btn-label"><?php echo JText::_('PLG_DJACCESSIBILITY_DARK_CONTRAST'); ?></span>
				</button>
			</li>
			<li class="djacc__item djacc__item--contrast">
				<button class="djacc__btn djacc__btn--light-contrast" title="<?php echo JText::_('PLG_DJACCESSIBILITY_LIGHT_CONTRAST'); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32">
						<g transform="translate(7 7)" fill="none" stroke="#fff" stroke-width="2">
							<circle cx="9" cy="9" r="9" stroke="none"/>
							<circle cx="9" cy="9" r="8" fill="none"/>
						</g>
						<rect width="2" height="5" rx="1" transform="translate(15)" fill="#fff"/>
						<rect width="2" height="5" rx="1" transform="translate(26.607 3.979) rotate(45)" fill="#fff"/>
						<rect width="2" height="5" rx="1" transform="translate(32 15) rotate(90)" fill="#fff"/>
						<rect width="2" height="5" rx="1" transform="translate(28.021 26.607) rotate(135)" fill="#fff"/>
						<rect width="2" height="5" rx="1" transform="translate(15 27)" fill="#fff"/>
						<rect width="2" height="5" rx="1" transform="translate(7.515 23.071) rotate(45)" fill="#fff"/>
						<rect width="2" height="5" rx="1" transform="translate(5 15) rotate(90)" fill="#fff"/>
						<rect width="2" height="5" rx="1" transform="translate(8.929 7.515) rotate(135)" fill="#fff"/>
					</svg>
					<span class="djacc_btn-label"><?php echo JText::_('PLG_DJACCESSIBILITY_LIGHT_CONTRAST'); ?></span>
				</button>
			</li>
			
			<li class="djacc__item djacc__item--contrast">
				<button class="djacc__btn djacc__btn--low-saturation" title="<?php echo JText::_('PLG_DJACCESSIBILITY_LOW_SATURATION'); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
						<g fill="none" stroke="#fff" stroke-width="2">
							<circle cx="12" cy="12" r="12" stroke="none"/>
							<circle cx="12" cy="12" r="11" fill="none"/>
						</g>
						<path d="M0,12A12,12,0,0,1,6,1.6V22.394A12,12,0,0,1,0,12Z" transform="translate(0 24) rotate(-90)" fill="#fff"/>
					</svg>
					<span class="djacc_btn-label"><?php echo JText::_('PLG_DJACCESSIBILITY_LOW_SATURATION'); ?></span>
				</button>
			</li>
			<li class="djacc__item djacc__item--contrast">
				<button class="djacc__btn djacc__btn--high-saturation" title="<?php echo JText::_('PLG_DJACCESSIBILITY_HIGH_SATURATION'); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
						<g fill="none" stroke="#fff" stroke-width="2">
							<circle cx="12" cy="12" r="12" stroke="none"/>
							<circle cx="12" cy="12" r="11" fill="none"/>
						</g>
						<path d="M0,12A12.006,12.006,0,0,1,17,1.088V22.911A12.006,12.006,0,0,1,0,12Z" transform="translate(0 24) rotate(-90)" fill="#fff"/>
					</svg>
					<span class="djacc_btn-label"><?php echo JText::_('PLG_DJACCESSIBILITY_HIGH_SATURATION'); ?></span>
				</button>
			</li>
			<li class="djacc__item">
				<button class="djacc__btn djacc__btn--highlight-links" title="<?php echo JText::_('PLG_DJACCESSIBILITY_HIGHLIGHT_LINKS'); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
						<rect width="24" height="24" fill="none"/>
						<path d="M3.535,21.92a5.005,5.005,0,0,1,0-7.071L6.364,12.02a1,1,0,0,1,1.415,1.413L4.95,16.263a3,3,0,0,0,4.243,4.243l2.828-2.828h0a1,1,0,1,1,1.414,1.415L10.607,21.92a5,5,0,0,1-7.072,0Zm2.829-2.828a1,1,0,0,1,0-1.415L17.678,6.364a1,1,0,1,1,1.415,1.414L7.779,19.092a1,1,0,0,1-1.415,0Zm11.314-5.657a1,1,0,0,1,0-1.413l2.829-2.829A3,3,0,1,0,16.263,4.95L13.436,7.777h0a1,1,0,0,1-1.414-1.414l2.828-2.829a5,5,0,1,1,7.071,7.071l-2.828,2.828a1,1,0,0,1-1.415,0Z" transform="translate(-0.728 -0.728)" fill="#fff"/>
					</svg>
					<span class="djacc_btn-label"><?php echo JText::_('PLG_DJACCESSIBILITY_HIGHLIGHT_LINKS'); ?></span>
				</button>
			</li>
			<li class="djacc__item">
				<button class="djacc__btn djacc__btn--highlight-titles" title="<?php echo JText::_('PLG_DJACCESSIBILITY_HIGHLIGHT_TITLES'); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
						<rect width="2" height="14" rx="1" transform="translate(5 5)" fill="#fff"/>
						<rect width="2" height="14" rx="1" transform="translate(10 5)" fill="#fff"/>
						<rect width="2" height="14" rx="1" transform="translate(17 5)" fill="#fff"/>
						<rect width="2" height="7" rx="1" transform="translate(12 11) rotate(90)" fill="#fff"/>
						<rect width="2" height="5" rx="1" transform="translate(19 5) rotate(90)" fill="#fff"/>
						<g fill="none" stroke="#fff" stroke-width="2">
							<rect width="24" height="24" rx="4" stroke="none"/>
							<rect x="1" y="1" width="22" height="22" rx="3" fill="none"/>
						</g>
					</svg>
					<span class="djacc_btn-label"><?php echo JText::_('PLG_DJACCESSIBILITY_HIGHLIGHT_TITLES'); ?></span>
				</button>
			</li>
			<li class="djacc__item">
				<button class="djacc__btn djacc__btn--screen-reader" title="<?php echo JText::_('PLG_DJACCESSIBILITY_SCREEN_READER'); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
						<g fill="none" stroke="#fff" stroke-width="2">
							<circle cx="12" cy="12" r="12" stroke="none"/>
							<circle cx="12" cy="12" r="11" fill="none"/>
						</g>
						<path d="M2907.964,170h1.91l1.369-2.584,2.951,8.363,2.5-11.585L2919,170h2.132" transform="translate(-2902.548 -158)" fill="none" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"/>
					</svg>
					<span class="djacc_btn-label"><?php echo JText::_('PLG_DJACCESSIBILITY_SCREEN_READER'); ?></span>
				</button>
			</li>
			<li class="djacc__item">
				<button class="djacc__btn djacc__btn--read-mode" title="<?php echo JText::_('PLG_DJACCESSIBILITY_READ_MODE'); ?>">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
						<g fill="none" stroke="#fff" stroke-width="2">
							<rect width="24" height="24" rx="4" stroke="none"/>
							<rect x="1" y="1" width="22" height="22" rx="3" fill="none"/>
						</g>
						<rect width="14" height="2" rx="1" transform="translate(5 7)" fill="#fff"/>
						<rect width="14" height="2" rx="1" transform="translate(5 11)" fill="#fff"/>
						<rect width="7" height="2" rx="1" transform="translate(5 15)" fill="#fff"/>
					</svg>
					<span class="djacc_btn-label"><?php echo JText::_('PLG_DJACCESSIBILITY_READ_MODE'); ?></span>
				</button>
			</li>
			<li class="djacc__item djacc__item--full">
				<span class="djacc__arrows djacc__arrows--zoom">
					<span class="djacc__label"><?php echo JText::_('PLG_DJACCESSIBILITY_ZOOM'); ?></span>
					<span class="djacc__bar"></span>
					<span class="djacc__size">100<span class="djacc__percent">%</span></span>
					<button class="djacc__dec" aria-label="<?php echo JText::_('PLG_DJACCESSIBILITY_ZOOM_DEC'); ?>" title="<?php echo JText::_('PLG_DJACCESSIBILITY_ZOOM_DEC'); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="10" height="2" viewBox="0 0 10 2">
							<g transform="translate(1 1)">
								<line x1="8" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="2"/>
							</g>
						</svg>
					</button>
					<button class="djacc__inc" aria-label="<?php echo JText::_('PLG_DJACCESSIBILITY_ZOOM_INC'); ?>" title="<?php echo JText::_('PLG_DJACCESSIBILITY_ZOOM_INC'); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10">
							<g transform="translate(1 1)">
								<line y2="8" transform="translate(4)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="2"/>
								<line x1="8" transform="translate(0 4)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="2"/>
							</g>
						</svg>
					</button>
				</span>
			</li>
			<li class="djacc__item djacc__item--full">
				<span class="djacc__arrows djacc__arrows--font-size">
					<span class="djacc__label"><?php echo JText::_('PLG_DJACCESSIBILITY_FONT_SIZE'); ?></span>
					<span class="djacc__bar"></span>
					<span class="djacc__size">100<span class="djacc__percent">%</span></span>
					<button class="djacc__dec" aria-label="<?php echo JText::_('PLG_DJACCESSIBILITY_FONT_DEC'); ?>" title="<?php echo JText::_('PLG_DJACCESSIBILITY_FONT_DEC'); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="10" height="2" viewBox="0 0 10 2">
							<g transform="translate(1 1)">
								<line x1="8" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="2"/>
							</g>
						</svg>
					</button>
					<button class="djacc__inc" aria-label="<?php echo JText::_('PLG_DJACCESSIBILITY_FONT_INC'); ?>" title="<?php echo JText::_('PLG_DJACCESSIBILITY_FONT_INC'); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10">
							<g transform="translate(1 1)">
								<line y2="8" transform="translate(4)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="2"/>
								<line x1="8" transform="translate(0 4)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="2"/>
							</g>
						</svg>
					</button>
				</span>
			</li>
			<li class="djacc__item djacc__item--full">
				<span class="djacc__arrows djacc__arrows--line-height">
					<span class="djacc__label"><?php echo JText::_('PLG_DJACCESSIBILITY_LINE_HEIGHT'); ?></span>
					<span class="djacc__bar"></span>
					<span class="djacc__size">100<span class="djacc__percent">%</span></span>
					<button class="djacc__dec" aria-label="<?php echo JText::_('PLG_DJACCESSIBILITY_LINE_DEC'); ?>" title="<?php echo JText::_('PLG_DJACCESSIBILITY_LINE_DEC'); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="10" height="2" viewBox="0 0 10 2">
							<g transform="translate(1 1)">
								<line x1="8" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="2"/>
							</g>
						</svg>
					</button>
					<button class="djacc__inc" aria-label="<?php echo JText::_('PLG_DJACCESSIBILITY_LINE_INC'); ?>" title="<?php echo JText::_('PLG_DJACCESSIBILITY_LINE_INC'); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10">
							<g transform="translate(1 1)">
								<line y2="8" transform="translate(4)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="2"/>
								<line x1="8" transform="translate(0 4)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="2"/>
							</g>
						</svg>
					</button>
				</span>
			</li>
			<li class="djacc__item djacc__item--full">
				<span class="djacc__arrows djacc__arrows--letter-spacing">
					<span class="djacc__label"><?php echo JText::_('PLG_DJACCESSIBILITY_LETTER_SPACING'); ?></span>
					<span class="djacc__bar"></span>
					<span class="djacc__size">100<span class="djacc__percent">%</span></span>
					<button class="djacc__dec" aria-label="<?php echo JText::_('PLG_DJACCESSIBILITY_LETTER_DEC'); ?>" title="<?php echo JText::_('PLG_DJACCESSIBILITY_LETTER_DEC'); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="10" height="2" viewBox="0 0 10 2">
							<g transform="translate(1 1)">
								<line x1="8" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="2"/>
							</g>
						</svg>
					</button>
					<button class="djacc__inc" aria-label="<?php echo JText::_('PLG_DJACCESSIBILITY_LETTER_INC'); ?>" title="<?php echo JText::_('PLG_DJACCESSIBILITY_LETTER_INC'); ?>">
						<svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10">
							<g transform="translate(1 1)">
								<line y2="8" transform="translate(4)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="2"/>
								<line x1="8" transform="translate(0 4)" fill="none" stroke="#fff" stroke-linecap="round" stroke-width="2"/>
							</g>
						</svg>
					</button>
				</span>
			</li>
		</ul>
	</div>
</section>