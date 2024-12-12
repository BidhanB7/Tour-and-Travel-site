const urlParams = new URLSearchParams(window.location.search);
    const packageName = urlParams.get('package');
    
    if (packageName) {
      document.getElementById('packageName').value = packageName;
    } 