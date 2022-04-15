/* global wp */

import ColorAlphaControl from './ColorAlphaControl';

// Register control type with Customizer.
wp.customize.controlConstructor['shapla-color-alpha'] = ColorAlphaControl;
