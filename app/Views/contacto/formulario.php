<fieldset>
    <?php if (isset($db['mensaje'])): ?>
        <div class="alert alert-success">
            <?php echo $db['mensaje']; ?>
        </div>
        <script>
            setTimeout(function () {
                window.location.href = "/proyecto";
            }, 1500);
        </script>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <?php if (isset($db['error'])): ?>
        <div class="alert alert-danger">
            <?php echo $db['error']; ?>
        </div>
    <?php endif; ?>

    <div class="mb-3">
        <label for="asunto" class="form-label">Asunto</label>
        <textarea class="form-control" id="asunto" name="asunto"
            rows="10"><?php echo (isset($asunto) ? $asunto : '') ?></textarea>
    </div>

    <!--<pre><code><?php print_r($datos) ?></code></pre>-->
</fieldset>