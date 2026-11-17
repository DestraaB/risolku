<!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <?php if ($this->session->flashdata('play_cekring')): ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    let sudahBunyi = false;

    function playCekring() {
        if (sudahBunyi) return;
        const AudioCtx = window.AudioContext || window.webkitAudioContext;
        if (!AudioCtx) return;

        const ctx = new AudioCtx();
        if (ctx.state === 'suspended') {
            ctx.resume();
        }
        if (ctx.state !== 'running') return;

        sudahBunyi = true;
        const now = ctx.currentTime;

        // Nada pertama: "Ce-"
        const osc1 = ctx.createOscillator();
        const gain1 = ctx.createGain();
        osc1.type = 'triangle';
        osc1.frequency.setValueAtTime(1318.51, now);
        gain1.gain.setValueAtTime(0.3, now);
        gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.12);
        osc1.connect(gain1);
        gain1.connect(ctx.destination);
        osc1.start(now);
        osc1.stop(now + 0.12);

        // Nada kedua: "-kring!"
        const osc2 = ctx.createOscillator();
        const osc3 = ctx.createOscillator();
        const gain2 = ctx.createGain();
        osc2.type = 'sine';
        osc3.type = 'triangle';
        osc2.frequency.setValueAtTime(2637.02, now + 0.09);
        osc3.frequency.setValueAtTime(3951.07, now + 0.09);

        gain2.gain.setValueAtTime(0.001, now);
        gain2.gain.setValueAtTime(0.35, now + 0.09);
        gain2.gain.exponentialRampToValueAtTime(0.001, now + 0.75);

        osc2.connect(gain2);
        osc3.connect(gain2);
        gain2.connect(ctx.destination);
        osc2.start(now + 0.09);
        osc3.start(now + 0.09);
        osc2.stop(now + 0.75);
        osc3.stop(now + 0.75);
    }

    playCekring();

    // Cadangan jika browser menahan autoplay sebelum layar disentuh
    document.addEventListener('click', playCekring, { once: true });
    document.addEventListener('touchstart', playCekring, { once: true });
});
</script>
<?php endif; ?>
</body>
</html>