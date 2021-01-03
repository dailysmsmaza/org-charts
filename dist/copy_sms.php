<html>
<head>
</head>
<body>
<script>

  	var clipboard = new Clipboard('.btn', {
    text: function(trigger) {
        return trigger.getAttribute('aria-label');
    }
});
clipboard.on('success', function(e) {
    console.info('Action:', e.action);
    console.info('Text:', e.text);
    console.info('Trigger:', e.trigger);

    e.clearSelection();
});

clipboard.on('error', function(e) {
    console.error('Action:', e.action);
    console.error('Trigger:', e.trigger);
});

</script>
</body>
</html>