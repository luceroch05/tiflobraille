document.addEventListener('DOMContentLoaded', function() {
  // Cargar configuraciones inmediatamente
  loadAccessibilitySettings();
  
  // Envolver el contenido en content-wrapper si no existe
  if (!document.getElementById('content-wrapper')) {
    const bodyContent = document.body.innerHTML;
    document.body.innerHTML = '<div id="content-wrapper">' + bodyContent + '</div>';
    
    // Recargar referencias a elementos de accesibilidad después de modificar el DOM
    setTimeout(function() {
      setupAccessibilityToolbar();
    }, 100);
  } else {
    setupAccessibilityToolbar();
  }
});

function setupAccessibilityToolbar() {
  // Configurar el botón de toggle
  const accessibilityToggle = document.getElementById('accessibilityToggle');
  const accessibilityToolbar = document.getElementById('accessibilityToolbar');
  
  if (accessibilityToggle && accessibilityToolbar) {
    // Reemplazar para eliminar listeners anteriores
    const newToggle = accessibilityToggle.cloneNode(true);
    accessibilityToggle.parentNode.replaceChild(newToggle, accessibilityToggle);
    
    newToggle.addEventListener('click', function() {
      accessibilityToolbar.classList.toggle('open');
      const isOpen = accessibilityToolbar.classList.contains('open');
      
      this.setAttribute('aria-pressed', isOpen);
      this.innerHTML = isOpen ? '<i class="tf-ion-close"></i>' : '<i class="tf-ion-eye"></i>';
      
      saveAccessibilitySetting('toolbarOpen', isOpen);
    });
    
    // Estado inicial
    if (getAccessibilitySetting('toolbarOpen') === true) {
      accessibilityToolbar.classList.add('open');
      newToggle.setAttribute('aria-pressed', 'true');
      newToggle.innerHTML = '<i class="tf-ion-close"></i>';
    }
  }
  
  // Configurar demás funciones
  setupDarkMode();
  setupTextSize();
  setupHighlightLinks();
  setupSpacedText();
  setupBigCursor();
  setupResetButton();
}

function getAccessibilitySetting(setting) {
  const settings = JSON.parse(localStorage.getItem('accessibilitySettings') || '{}');
  return settings[setting];
}

function setupDarkMode() {
  const darkModeToggle = document.getElementById('darkModeToggle');
  if (darkModeToggle) {
    const newToggle = darkModeToggle.cloneNode(true);
    darkModeToggle.parentNode.replaceChild(newToggle, darkModeToggle);
    
    newToggle.addEventListener('click', function() {
      document.body.classList.toggle('dark-mode');
      updateButtonState(this, document.body.classList.contains('dark-mode'));
      saveAccessibilitySetting('darkMode', document.body.classList.contains('dark-mode'));
    });
    
    // Estado inicial
    if (getAccessibilitySetting('darkMode') === true) {
      document.body.classList.add('dark-mode');
      updateButtonState(newToggle, true);
    }
  }
}

function setupTextSize() {
  const decreaseText = document.getElementById('decreaseText');
  const normalText = document.getElementById('normalText');
  const increaseText = document.getElementById('increaseText');
  
  function removeZoomClasses() {
    document.body.classList.remove('zoom-level-1', 'zoom-level-2', 'zoom-level-3');
  }
  
  if (decreaseText) {
    const newDecrease = decreaseText.cloneNode(true);
    decreaseText.parentNode.replaceChild(newDecrease, decreaseText);
    
    newDecrease.addEventListener('click', function() {
      removeZoomClasses();
      saveAccessibilitySetting('zoomLevel', 0);
    });
  }
  
  if (normalText) {
    const newNormal = normalText.cloneNode(true);
    normalText.parentNode.replaceChild(newNormal, normalText);
    
    newNormal.addEventListener('click', function() {
      removeZoomClasses();
      document.body.classList.add('zoom-level-1');
      saveAccessibilitySetting('zoomLevel', 1);
    });
  }
  
  if (increaseText) {
    const newIncrease = increaseText.cloneNode(true);
    increaseText.parentNode.replaceChild(newIncrease, increaseText);
    
    newIncrease.addEventListener('click', function() {
      removeZoomClasses();
      document.body.classList.add('zoom-level-2');
      saveAccessibilitySetting('zoomLevel', 2);
    });
    
    newIncrease.addEventListener('dblclick', function() {
      removeZoomClasses();
      document.body.classList.add('zoom-level-3');
      saveAccessibilitySetting('zoomLevel', 3);
    });
  }
  
  // Estado inicial
  const zoomLevel = getAccessibilitySetting('zoomLevel');
  if (zoomLevel) {
    removeZoomClasses();
    if (zoomLevel === 1) document.body.classList.add('zoom-level-1');
    if (zoomLevel === 2) document.body.classList.add('zoom-level-2');
    if (zoomLevel === 3) document.body.classList.add('zoom-level-3');
  }
}

function setupHighlightLinks() {
  const highlightLinks = document.getElementById('highlightLinks');
  if (highlightLinks) {
    const newHighlight = highlightLinks.cloneNode(true);
    highlightLinks.parentNode.replaceChild(newHighlight, highlightLinks);
    
    newHighlight.addEventListener('click', function() {
      document.body.classList.toggle('highlight-links');
      updateButtonState(this, document.body.classList.contains('highlight-links'));
      saveAccessibilitySetting('highlightLinks', document.body.classList.contains('highlight-links'));
    });
    
    // Estado inicial
    if (getAccessibilitySetting('highlightLinks') === true) {
      document.body.classList.add('highlight-links');
      updateButtonState(newHighlight, true);
    }
  }
}

function setupSpacedText() {
  const spacedText = document.getElementById('spacedText');
  if (spacedText) {
    const newSpaced = spacedText.cloneNode(true);
    spacedText.parentNode.replaceChild(newSpaced, spacedText);
    
    newSpaced.addEventListener('click', function() {
      document.body.classList.toggle('spaced-text');
      updateButtonState(this, document.body.classList.contains('spaced-text'));
      saveAccessibilitySetting('spacedText', document.body.classList.contains('spaced-text'));
    });
    
    // Estado inicial
    if (getAccessibilitySetting('spacedText') === true) {
      document.body.classList.add('spaced-text');
      updateButtonState(newSpaced, true);
    }
  }
}

function setupBigCursor() {
  const bigCursor = document.getElementById('bigCursor');
  if (bigCursor) {
    const newCursor = bigCursor.cloneNode(true);
    bigCursor.parentNode.replaceChild(newCursor, bigCursor);
    
    newCursor.addEventListener('click', function() {
      document.body.classList.toggle('big-cursor');
      updateButtonState(this, document.body.classList.contains('big-cursor'));
      saveAccessibilitySetting('bigCursor', document.body.classList.contains('big-cursor'));
    });
    
    // Estado inicial
    if (getAccessibilitySetting('bigCursor') === true) {
      document.body.classList.add('big-cursor');
      updateButtonState(newCursor, true);
    }
  }
}

function setupResetButton() {
  const resetAccessibility = document.getElementById('resetAccessibility');
  if (resetAccessibility) {
    const newReset = resetAccessibility.cloneNode(true);
    resetAccessibility.parentNode.replaceChild(newReset, resetAccessibility);
    
    newReset.addEventListener('click', function() {
      resetAllSettings();
    });
  }
}

function updateButtonState(button, isActive) {
  if (isActive) {
    button.classList.add('active');
    button.setAttribute('aria-pressed', 'true');
  } else {
    button.classList.remove('active');
    button.setAttribute('aria-pressed', 'false');
  }
}

function saveAccessibilitySetting(setting, value) {
  const settings = JSON.parse(localStorage.getItem('accessibilitySettings') || '{}');
  settings[setting] = value;
  localStorage.setItem('accessibilitySettings', JSON.stringify(settings));
}

function loadAccessibilitySettings() {
  const settings = JSON.parse(localStorage.getItem('accessibilitySettings') || '{}');
  
  // Aplicar modo oscuro
  if (settings.darkMode) {
    document.body.classList.add('dark-mode');
  } else {
    document.body.classList.remove('dark-mode');
  }
  
  // Aplicar nivel de zoom
  document.body.classList.remove('zoom-level-1', 'zoom-level-2', 'zoom-level-3');
  if (settings.zoomLevel) {
    if (settings.zoomLevel === 1) document.body.classList.add('zoom-level-1');
    if (settings.zoomLevel === 2) document.body.classList.add('zoom-level-2');
    if (settings.zoomLevel === 3) document.body.classList.add('zoom-level-3');
  }
  
  // Aplicar resaltado de enlaces
  if (settings.highlightLinks) {
    document.body.classList.add('highlight-links');
  } else {
    document.body.classList.remove('highlight-links');
  }
  
  // Aplicar texto espaciado
  if (settings.spacedText) {
    document.body.classList.add('spaced-text');
  } else {
    document.body.classList.remove('spaced-text');
  }
  
  // Aplicar cursor grande
  if (settings.bigCursor) {
    document.body.classList.add('big-cursor');
  } else {
    document.body.classList.remove('big-cursor');
  }
}

function resetAllSettings() {
  // Eliminar todas las clases de accesibilidad
  document.body.classList.remove(
    'dark-mode', 
    'zoom-level-1', 
    'zoom-level-2', 
    'zoom-level-3', 
    'highlight-links', 
    'spaced-text', 
    'big-cursor'
  );
  
  // Restablecer estados de botones
  const buttons = [
    document.getElementById('darkModeToggle'),
    document.getElementById('highlightLinks'),
    document.getElementById('spacedText'),
    document.getElementById('bigCursor')
  ];
  
  buttons.forEach(button => {
    if (button) {
      button.classList.remove('active');
      button.setAttribute('aria-pressed', 'false');
    }
  });
  
  // Limpiar localStorage
  localStorage.removeItem('accessibilitySettings');
  
  // Restablecer estado de la barra
  const accessibilityToolbar = document.getElementById('accessibilityToolbar');
  const accessibilityToggle = document.getElementById('accessibilityToggle');
  
  if (accessibilityToolbar) {
    accessibilityToolbar.classList.remove('open');
  }
  
  if (accessibilityToggle) {
    accessibilityToggle.setAttribute('aria-pressed', 'false');
    accessibilityToggle.innerHTML = '<i class="tf-ion-eye"></i>';
  }
}