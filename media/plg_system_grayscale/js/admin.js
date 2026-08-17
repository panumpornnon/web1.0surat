/**
 * Grayscale Plugin Admin JavaScript
 * Shows percentage value in real-time for range slider
 * ThaiTone Color Picker
 */

(function() {
    'use strict';
    
    document.addEventListener('DOMContentLoaded', function() {
        initIntensityDisplay();
        initThaiToneColorPicker();
    });
    
    /**
     * Initialize intensity percentage display
     */
    function initIntensityDisplay() {
        const intensityInput = document.getElementById('jform_params_intensity');
        
        if (intensityInput) {
            const container = intensityInput.closest('.control-group');
            
            if (container) {
                // Create display element
                const displaySpan = document.createElement('span');
                displaySpan.className = 'gs-percentage-display';
                displaySpan.style.cssText = 'font-weight: bold; color: #3388cc; margin-left: 10px; font-size: 16px;';
                displaySpan.textContent = intensityInput.value + '%';
                
                // Insert after the range input
                const inputContainer = intensityInput.parentElement;
                inputContainer.appendChild(displaySpan);
                
                // Update on change and input
                function updateDisplay() {
                    displaySpan.textContent = intensityInput.value + '%';
                    
                    // Add animation
                    displaySpan.style.transform = 'scale(1.1)';
                    setTimeout(() => {
                        displaySpan.style.transform = 'scale(1)';
                    }, 200);
                }
                
                intensityInput.addEventListener('input', updateDisplay);
                intensityInput.addEventListener('change', updateDisplay);
                
                // Initial update
                updateDisplay();
            }
        }
    }
    
    /**
     * Initialize ThaiTone color picker
     */
    function initThaiToneColorPicker() {
        const barColorInput = document.getElementById('jform_params_bar_color');
        
        if (!barColorInput) return;
        
        const container = barColorInput.closest('.control-group');
        if (!container) return;
        
        // ThaiTone – Sukkaphap Collection (25 Colors)
        const thaiToneColors = [
            { name: 'dam-khe-ma', nameThai: 'ดำเขม่า', color: '#00040A', textColor: '#ffffff' },
            { name: 'tao', nameThai: 'เทา', color: '#7C7C7C', textColor: '#ffffff' },
            { name: 'phan-khram', nameThai: 'ผ่านคราม', color: '#364F5A', textColor: '#ffffff' },
            { name: 'khab-dam', nameThai: 'ขาบดำ', color: '#162836', textColor: '#ffffff' },
            { name: 'nil-kan', nameThai: 'นิลกาฬ', color: '#051520', textColor: '#ffffff' },
            { name: 'muek-jin', nameThai: 'หมึกจีน', color: '#494C54', textColor: '#ffffff' },
            { name: 'khe-ma-yang', nameThai: 'เขม่ายาง', color: '#6D6C67', textColor: '#ffffff' },
            { name: 'peek-ka', nameThai: 'ปีกกา', color: '#2A2D29', textColor: '#ffffff' },
            { name: 'dam-muek', nameThai: 'ดำหมึก', color: '#444547', textColor: '#ffffff' },
            { name: 'khiew-nil', nameThai: 'เขียวนิล', color: '#112B37', textColor: '#ffffff' },
            { name: 'look-wa', nameThai: 'ลูกหว้า', color: '#5A3E4C', textColor: '#ffffff' },
            { name: 'namtan-mai', nameThai: 'น้ำตาลไหม้', color: '#55383A', textColor: '#ffffff' },
            { name: 'som-rit-dech', nameThai: 'ส้มฤทธิเดช', color: '#685B4B', textColor: '#ffffff' },
            { name: 'lek-lai', nameThai: 'เหล็กไหล', color: '#4C3F2B', textColor: '#ffffff' },
            { name: 'mo-muek', nameThai: 'มอหมึก', color: '#5E6665', textColor: '#ffffff' },
            { name: 'sawat', nameThai: 'สวาด', color: '#918F95', textColor: '#ffffff' },
            { name: 'nam-rak', nameThai: 'น้ำรัก', color: '#4B2F2D', textColor: '#ffffff' },
            { name: 'som-rit', nameThai: 'ส้มฤทธิ์', color: '#8A7358', textColor: '#ffffff' },
            { name: 'kaki', nameThai: 'กากี', color: '#BBA88E', textColor: '#000000' },
            { name: 'tao-khieow', nameThai: 'เทาเขียว', color: '#BEC8BD', textColor: '#000000' },
            { name: 'dok-lao', nameThai: 'ดอกเลา', color: '#C5C1C6', textColor: '#000000' },
            { name: 'bua-roi', nameThai: 'บัวโรย', color: '#9A8F8C', textColor: '#ffffff' },
            { name: 'khwan-phloeng', nameThai: 'ควันเพลิง', color: '#AFA094', textColor: '#000000' },
            { name: 'mok', nameThai: 'หมอก', color: '#D5D3C2', textColor: '#000000' },
            { name: 'khao-khab', nameThai: 'ขาวขาบ', color: '#E3E5DF', textColor: '#000000' }
        ];
        
        // Create color picker UI
        const colorPickerWrapper = document.createElement('div');
        colorPickerWrapper.className = 'thaitone-color-picker';
        colorPickerWrapper.style.cssText = 'margin-top: 15px;';
        
        // Title
        const title = document.createElement('h4');
        title.textContent = '🎨 เลือกสีแถบ';
        title.style.cssText = 'margin: 0 0 20px 0; font-size: 16px; font-weight: 700; color: #1a1a1a; letter-spacing: 0.3px;';
        colorPickerWrapper.appendChild(title);
        
        // Color grid - วงกลมเล็ก สวยงาม
        const colorGrid = document.createElement('div');
        colorGrid.style.cssText = 'display: grid; grid-template-columns: repeat(auto-fill, minmax(44px, 1fr)); gap: 12px; padding: 10px 0;';
        
        // Create color buttons
        thaiToneColors.forEach(color => {
            const colorButton = document.createElement('button');
            colorButton.type = 'button';
            colorButton.className = 'thaitone-color-btn';
            colorButton.dataset.color = color.color;
            colorButton.style.cssText = `
                border: 3px solid #e0e0e0;
                border-radius: 50%;
                cursor: pointer;
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                background: ${color.color};
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 2px 4px rgba(0,0,0,0.08);
                width: 44px;
                height: 44px;
                margin: 0 auto;
                position: relative;
            `;
            
            colorButton.dataset.colorName = color.name.toLowerCase();
            colorButton.innerHTML = ``;
            
            // เพิ่ม tooltip กับชื่อสี
            colorButton.title = color.nameThai;
            
            // Click handler
            colorButton.addEventListener('click', function(e) {
                e.preventDefault();
                
                // Update hidden input
                const colorValue = color.name.toLowerCase();
                barColorInput.value = colorValue;
                
                // Update active state - remove all active classes
                document.querySelectorAll('.thaitone-color-btn').forEach(btn => {
                    btn.classList.remove('active');
                    btn.style.borderColor = '#e0e0e0';
                    btn.style.borderWidth = '3px';
                    btn.style.transform = 'scale(1)';
                    btn.style.boxShadow = '0 2px 4px rgba(0,0,0,0.08)';
                    btn.style.zIndex = '1';
                });
                
                // Make this button active
                this.classList.add('active');
                this.style.borderColor = '#fff';
                this.style.borderWidth = '4px';
                this.style.transform = 'scale(1.15)';
                this.style.boxShadow = `0 0 0 3px rgba(0,0,0,0.15), 0 4px 12px rgba(0,0,0,0.25)`;
                this.style.zIndex = '10';
                
                // Trigger change event for Joomla form
                const event = new Event('change', { bubbles: true });
                barColorInput.dispatchEvent(event);
                
                console.log('✓ Selected:', color.nameThai);
            });
            
            // Hover effect - elegant and smooth
            colorButton.addEventListener('mouseenter', function() {
                if (!this.classList.contains('active')) {
                    this.style.transform = 'translateY(-3px) scale(1.08)';
                    this.style.boxShadow = '0 6px 12px rgba(0,0,0,0.15)';
                    this.style.zIndex = '5';
                }
            });
            
            colorButton.addEventListener('mouseleave', function() {
                if (!this.classList.contains('active')) {
                    this.style.transform = 'translateY(0) scale(1)';
                    this.style.boxShadow = '0 2px 4px rgba(0,0,0,0.08)';
                    this.style.zIndex = '1';
                }
            });
            
            colorGrid.appendChild(colorButton);
        });
        
        colorPickerWrapper.appendChild(colorGrid);
        container.appendChild(colorPickerWrapper);
        
        // Set active color on load
        const currentValue = barColorInput.value || 'dam-khe-ma';
        setTimeout(() => {
            // Find and click the button matching the current value
            const allButtons = document.querySelectorAll('.thaitone-color-btn');
            let found = false;
            
            allButtons.forEach(btn => {
                // Check using dataset
                if (btn.dataset.colorName === currentValue) {
                    btn.click();
                    found = true;
                }
            });
            
            // If no match found, activate first button (default: dam-khe-ma)
            if (!found && allButtons.length > 0) {
                allButtons[0].click();
            }
        }, 300);
    }
})();
