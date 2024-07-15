// assets/controllers/my-toggle-password_controller.js

import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {
        this.element.addEventListener('toggle-password:connect', this._onConnect);
        this.element.addEventListener('toggle-password:show', this._onShow);
        this.element.addEventListener('toggle-password:hide', this._onHide);
    }

    disconnect() {
        // You should always remove listeners when the controller is disconnected to avoid side-effects
        this.element.removeEventListener('toggle-password:connect', this._onConnect);
        this.element.removeEventListener('toggle-password:show', this._onShow);
        this.element.removeEventListener('toggle-password:hide', this._onHide);
    }

    _onConnect(event) {
        // The TogglePassword was just created.
        // You can for example add custom attributes to the toggle element
        const toggle = event.detail.button;
        toggle.dataset.customProperty = 'my-custom-value';

        // Or add a custom class to the input element
        const input = event.detail.element;
        input.classList.add('my-custom-class');
    }

    _onShow(event) {
        // The TogglePassword input has just been toggled for text type.
        // You can for example add custom attributes to the toggle element
        const toggle = event.detail.button;
        toggle.dataset.visible = true;

        // Or add a custom class to the input element
        const input = event.detail.element;
        input.classList.add('my-custom-class');
    }

    _onHide(event) {
        // The TogglePassword input has just been toggled for password type.
        // You can for example update custom attributes to the toggle element
        const toggle = event.detail.button;
        delete toggle.dataset.visible;

        // Or remove a custom class to the input element
        const input = event.detail.element;
        input.classList.remove('my-custom-class');
    }
}