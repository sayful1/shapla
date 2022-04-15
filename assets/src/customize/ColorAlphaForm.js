/* globals wp */
import React, {Component, createRef} from "react";
import {ColorPicker} from '@wordpress/components';

class ColorAlphaForm extends Component {
	/**
	 * Specifies the default values for props:
	 */
	static defaultProps = {
		customizerSetting: {id: null},
		control: {id: null},
		label: '',
		defaultValue: null,
	};

	/**
	 * Component constructor
	 *
	 * @param props
	 */
	constructor(props) {
		super(props);
		this.colorPickerRef = createRef();
		this.state = {isActive: false}

		this.setValue = this.setValue.bind(this);
		this.resetValue = this.resetValue.bind(this);
	}

	/**
	 * Close picker on outside click
	 */
	componentDidMount() {
		document.addEventListener('click', event => {
			if (this.state.isActive) {
				if (!this.colorPickerRef.current.contains(event.target)) {
					this.setState(state => state.isActive = false);
				}
			}
		});
	}

	/**
	 * Save the value when changing the color-picker.
	 *
	 * @param {string} color - The color object from react-color.
	 * @return {void}
	 */
	setValue(color) {
		wp.customize.control(this.props.customizerSetting.id).setting.set(color);
	}

	/**
	 * Reset value to its default.
	 *
	 * @param {Object} event - The click event.
	 * @return {void}
	 */
	resetValue(event) {
		event.preventDefault();
		this.setValue(this.props.defaultValue ? this.props.defaultValue : '');
	}

	/**
	 * Render component content
	 *
	 * @return {JSX.Element}
	 */
	render() {
		const {label, description, value, choices, control, setNotificationContainer} = this.props;
		return (
			<div ref={this.colorPickerRef}>
				<label className="customize-control-title"
					   htmlFor={control.id + '-input'}>{label}</label>
				<span className="description customize-control-description"
					  dangerouslySetInnerHTML={{__html: description}}/>
				<div className="customize-control-notifications-container" ref={setNotificationContainer}/>
				<div className="customize-control-content">
					<button type="button" className="button wp-color-result"
							onClick={() => this.setState(state => state.isActive = !state.isActive)}
							style={{
								padding: '0px 0px 0px 30px',
								backgroundColor: 'array' === choices.save_as ? value.css : value,
								fontSize: '12px'
							}}
					>
						<span className="wp-color-result-text">{window.wp.i18n.__('Select Color')}</span>
					</button>
					<div style={{display: (this.state.isActive ? 'block' : 'none'), marginTop: '1rem'}}>
						<div className="customize-control-input-wrapper"
							 style={{display: 'flex', marginBottom: '12px'}}>
							<input
								className="customize-control-color-input"
								type="text"
								style={{borderRadius: '0 4px 4px 0', width: '100%'}}
								value={'array' === choices.save_as ? value.css : value}
								onChange={(event) => this.setValue(event.target.value)}
								id={control.id + '-input'}
							/>
							<button className="button" onClick={this.resetValue}>{window.wp.i18n.__('Default')}</button>
						</div>
						<ColorPicker
							className="customize-control-color-picker"
							{...choices}
							color={'array' === choices.save_as ? value.css : value}
							onChange={(hex8) => this.setValue(hex8)}
							enableAlpha={true}
							copyFormat="rgb"
						/>
					</div>
				</div>
			</div>
		)
	}
}

export default ColorAlphaForm;
