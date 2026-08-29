/**
 * Portfolio Next-Gen Interactive Experience Engine
 * Features:
 * 1. Constellation Particle Canvas with Mouse Interactivity
 * 2. 3D Tilt Cards & Mouse Spotlight Illumination
 * 3. Dynamic Role Typewriter Engine
 * 4. Animated Number Counters (Viewport Triggered)
 * 5. Animated Skill Progress Bars
 * 6. Floating Back-to-Top with Circular Progress Ring
 * 7. Interactive Project Category Filtering
 * 8. Scroll Reveal Observer
 * 9. Navbar Scroll Visual Effect
 * 10. Lo-Fi Ambient Audio Player & Equalizer
 * 11. Interactive Project Cost & Timeline Estimator (Alpine Helper)
 */

document.addEventListener('DOMContentLoaded', () => {
    initConstellationCanvas();
    initSpotlightAndTilt();
    initTypewriter();
    initNumberCounters();
    initSkillProgressBars();
    initBackToTop();
    initProjectFilters();
    initScrollReveal();
    initNavbarScroll();
    initLofiPlayer();
});

/* ── 1. Constellation Particle Canvas ─────────────────────── */
function initConstellationCanvas() {
    const canvas = document.getElementById('bg-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let width = (canvas.width = window.innerWidth);
    let height = (canvas.height = window.innerHeight);

    let particles = [];
    const particleCount = Math.min(Math.floor((width * height) / 14000), 75);
    const connectionDistance = 140;
    const mouseConnectionDistance = 180;

    let mouse = {
        x: null,
        y: null,
        radius: 150,
    };

    window.addEventListener('mousemove', (e) => {
        mouse.x = e.clientX;
        mouse.y = e.clientY;
    });

    window.addEventListener('mouseleave', () => {
        mouse.x = null;
        mouse.y = null;
    });

    window.addEventListener('resize', () => {
        width = canvas.width = window.innerWidth;
        height = canvas.height = window.innerHeight;
    });

    class Particle {
        constructor() {
            this.x = Math.random() * width;
            this.y = Math.random() * height;
            this.vx = (Math.random() - 0.5) * 0.6;
            this.vy = (Math.random() - 0.5) * 0.6;
            this.radius = Math.random() * 2 + 1;
            const colors = ['#6366f1', '#06b6d4', '#a855f7', '#ec4899', '#38bdf8'];
            this.color = colors[Math.floor(Math.random() * colors.length)];
            this.alpha = Math.random() * 0.5 + 0.2;
        }

        update() {
            this.x += this.vx;
            this.y += this.vy;

            if (this.x < 0 || this.x > width) this.vx = -this.vx;
            if (this.y < 0 || this.y > height) this.vy = -this.vy;

            if (mouse.x !== null && mouse.y !== null) {
                const dx = mouse.x - this.x;
                const dy = mouse.y - this.y;
                const distance = Math.hypot(dx, dy);

                if (distance < mouse.radius) {
                    const force = (1 - distance / mouse.radius) * 0.8;
                    const angle = Math.atan2(dy, dx);
                    this.x += Math.cos(angle) * force * 1.2;
                    this.y += Math.sin(angle) * force * 1.2;
                }
            }
        }

        draw() {
            ctx.save();
            ctx.beginPath();
            ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
            ctx.fillStyle = this.color;
            ctx.globalAlpha = this.alpha;
            ctx.shadowBlur = 8;
            ctx.shadowColor = this.color;
            ctx.fill();
            ctx.restore();
        }
    }

    for (let i = 0; i < particleCount; i++) {
        particles.push(new Particle());
    }

    let animationFrameId;
    let isTabActive = true;

    document.addEventListener('visibilitychange', () => {
        isTabActive = !document.hidden;
        if (isTabActive) loop();
        else cancelAnimationFrame(animationFrameId);
    });

    function loop() {
        if (!isTabActive) return;
        ctx.clearRect(0, 0, width, height);

        for (let i = 0; i < particles.length; i++) {
            for (let j = i + 1; j < particles.length; j++) {
                const dx = particles[i].x - particles[j].x;
                const dy = particles[i].y - particles[j].y;
                const distance = Math.hypot(dx, dy);

                if (distance < connectionDistance) {
                    ctx.save();
                    ctx.beginPath();
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(particles[j].x, particles[j].y);
                    const opacity = (1 - distance / connectionDistance) * 0.18;
                    ctx.strokeStyle = `rgba(99, 102, 241, ${opacity})`;
                    ctx.lineWidth = 0.8;
                    ctx.stroke();
                    ctx.restore();
                }
            }

            if (mouse.x !== null && mouse.y !== null) {
                const dx = particles[i].x - mouse.x;
                const dy = particles[i].y - mouse.y;
                const distance = Math.hypot(dx, dy);

                if (distance < mouseConnectionDistance) {
                    ctx.save();
                    ctx.beginPath();
                    ctx.moveTo(particles[i].x, particles[i].y);
                    ctx.lineTo(mouse.x, mouse.y);
                    const opacity = (1 - distance / mouseConnectionDistance) * 0.25;
                    ctx.strokeStyle = `rgba(6, 182, 212, ${opacity})`;
                    ctx.lineWidth = 1;
                    ctx.stroke();
                    ctx.restore();
                }
            }

            particles[i].update();
            particles[i].draw();
        }

        animationFrameId = requestAnimationFrame(loop);
    }

    loop();
}

/* ── 2. 3D Tilt Cards & Mouse Spotlight Illumination ─────── */
function initSpotlightAndTilt() {
    const cards = document.querySelectorAll('.spotlight-card, .tilt-card');

    cards.forEach((card) => {
        card.addEventListener('mousemove', (e) => {
            const rect = card.getBoundingClientRect();
            const x = e.clientX - rect.left;
            const y = e.clientY - rect.top;

            card.style.setProperty('--mouse-x', `${x}px`);
            card.style.setProperty('--mouse-y', `${y}px`);

            if (card.classList.contains('tilt-card')) {
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                const rotateX = ((y - centerY) / centerY) * -7;
                const rotateY = ((x - centerX) / centerX) * 7;
                card.style.transform = `perspective(1000px) rotateX(${rotateX}deg) rotateY(${rotateY}deg) scale3d(1.02, 1.02, 1.02)`;
            }
        });

        card.addEventListener('mouseleave', () => {
            if (card.classList.contains('tilt-card')) {
                card.style.transform = 'perspective(1000px) rotateX(0deg) rotateY(0deg) scale3d(1, 1, 1)';
            }
        });
    });
}

/* ── 3. Dynamic Role Typewriter Engine ───────────────────── */
function initTypewriter() {
    const typewriterEl = document.getElementById('typewriter-role');
    if (!typewriterEl) return;

    let roles = ['Fullstack Developer', 'UI/UX Enthusiast', 'Modern Tech Explorer'];

    try {
        const rawRoles = typewriterEl.getAttribute('data-roles');
        if (rawRoles) {
            const parsed = JSON.parse(rawRoles);
            if (Array.isArray(parsed) && parsed.length > 0) {
                roles = parsed;
            }
        }
    } catch (e) {
        console.log('Typewriter: using default roles fallback.');
    }

    let roleIndex = 0;
    let charIndex = 0;
    let isDeleting = false;
    let typingSpeed = 90;

    function type() {
        const currentRole = roles[roleIndex];

        if (isDeleting) {
            typewriterEl.textContent = currentRole.substring(0, charIndex - 1);
            charIndex--;
            typingSpeed = 45;
        } else {
            typewriterEl.textContent = currentRole.substring(0, charIndex + 1);
            charIndex++;
            typingSpeed = 90;
        }

        if (!isDeleting && charIndex === currentRole.length) {
            typingSpeed = 2200;
            isDeleting = true;
        } else if (isDeleting && charIndex === 0) {
            isDeleting = false;
            roleIndex = (roleIndex + 1) % roles.length;
            typingSpeed = 400;
        }

        setTimeout(type, typingSpeed);
    }

    setTimeout(type, 800);
}

/* ── 4. Animated Number Counters ─────────────────────────── */
function initNumberCounters() {
    const counters = document.querySelectorAll('.stat-counter');
    if (!counters.length) return;

    const observer = new IntersectionObserver(
        (entries, obs) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const counter = entry.target;
                    const target = parseInt(counter.getAttribute('data-target'), 10) || 0;
                    const duration = 1600;
                    const startTime = performance.now();

                    function updateNumber(currentTime) {
                        const elapsed = currentTime - startTime;
                        const progress = Math.min(elapsed / duration, 1);
                        const easeProgress = 1 - Math.pow(1 - progress, 3);
                        const current = Math.floor(easeProgress * target);

                        counter.textContent = current;

                        if (progress < 1) {
                            requestAnimationFrame(updateNumber);
                        } else {
                            counter.textContent = target;
                        }
                    }

                    requestAnimationFrame(updateNumber);
                    obs.unobserve(counter);
                }
            });
        },
        { threshold: 0.5 }
    );

    counters.forEach((counter) => observer.observe(counter));
}

/* ── 5. Animated Skill Progress Bars ─────────────────────── */
function initSkillProgressBars() {
    const bars = document.querySelectorAll('.skill-progress-bar');
    if (!bars.length) return;

    const observer = new IntersectionObserver(
        (entries, obs) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    const bar = entry.target;
                    const progress = bar.getAttribute('data-progress') || '0';
                    bar.style.width = `${progress}%`;
                    obs.unobserve(bar);
                }
            });
        },
        { threshold: 0.3 }
    );

    bars.forEach((bar) => observer.observe(bar));
}

/* ── 6. Floating Back-to-Top with Circular Progress Ring ─── */
function initBackToTop() {
    const backToTopBtn = document.getElementById('back-to-top');
    const progressCircle = document.getElementById('progress-ring-circle');
    if (!backToTopBtn) return;

    const radius = 22;
    const circumference = 2 * Math.PI * radius;

    if (progressCircle) {
        progressCircle.style.strokeDasharray = `${circumference} ${circumference}`;
        progressCircle.style.strokeDashoffset = circumference;
    }

    function onScroll() {
        const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrollFraction = scrollHeight > 0 ? scrollTop / scrollHeight : 0;

        if (scrollTop > 300) {
            backToTopBtn.classList.add('visible');
        } else {
            backToTopBtn.classList.remove('visible');
        }

        if (progressCircle) {
            const offset = circumference - scrollFraction * circumference;
            progressCircle.style.strokeDashoffset = offset;
        }
    }

    window.addEventListener('scroll', onScroll, { passive: true });

    backToTopBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth',
        });
    });
}

/* ── 7. Interactive Project Category Filtering ───────────── */
function initProjectFilters() {
    const filterBtns = document.querySelectorAll('.filter-btn');
    const projectCards = document.querySelectorAll('.project-card-item');
    if (!filterBtns.length) return;

    filterBtns.forEach((btn) => {
        btn.addEventListener('click', () => {
            filterBtns.forEach((b) => b.classList.remove('active'));
            btn.classList.add('active');

            const filter = btn.getAttribute('data-filter');

            projectCards.forEach((card) => {
                const category = card.getAttribute('data-category') || '';
                const tags = card.getAttribute('data-tags') || '';
                const combined = (category + ' ' + tags).toLowerCase();

                if (filter === 'all' || combined.includes(filter.toLowerCase())) {
                    card.style.display = 'block';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'scale(1)';
                    }, 50);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        });
    });
}

/* ── 8. Scroll Reveal Observer ───────────────────────────── */
function initScrollReveal() {
    const reveals = document.querySelectorAll('.reveal');
    if (!reveals.length) return;

    const observer = new IntersectionObserver(
        (entries, obs) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('active');
                    obs.unobserve(entry.target);
                }
            });
        },
        { threshold: 0.1, rootMargin: '0px 0px -50px 0px' }
    );

    reveals.forEach((el) => observer.observe(el));
}

/* ── 9. Navbar Scroll Visual Effect ──────────────────────── */
function initNavbarScroll() {
    const navbar = document.querySelector('.navbar');
    if (!navbar) return;

    window.addEventListener('scroll', () => {
        if (window.scrollY > 40) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }, { passive: true });
}

/* ── 10. Lo-Fi Ambient Audio Player Engine ───────────────── */
function initLofiPlayer() {
    const playerWidget = document.getElementById('lofi-widget');
    const playBtn = document.getElementById('lofi-toggle');
    const audio = document.getElementById('lofi-audio');
    if (!playerWidget || !playBtn) return;

    let isPlaying = false;

    playBtn.addEventListener('click', () => {
        if (!isPlaying) {
            if (audio) {
                audio.volume = 0.4;
                audio.play().then(() => {
                    isPlaying = true;
                    playerWidget.classList.add('playing');
                    playBtn.innerHTML = "<i class='bx bx-pause text-xl'></i>";
                }).catch(() => {
                    startAmbientSynth();
                    isPlaying = true;
                    playerWidget.classList.add('playing');
                    playBtn.innerHTML = "<i class='bx bx-pause text-xl'></i>";
                });
            } else {
                startAmbientSynth();
                isPlaying = true;
                playerWidget.classList.add('playing');
                playBtn.innerHTML = "<i class='bx bx-pause text-xl'></i>";
            }
        } else {
            if (audio) audio.pause();
            stopAmbientSynth();
            isPlaying = false;
            playerWidget.classList.remove('playing');
            playBtn.innerHTML = "<i class='bx bx-play text-xl'></i>";
        }
    });

    let audioCtx = null;
    let synthInterval = null;

    function startAmbientSynth() {
        try {
            audioCtx = new (window.AudioContext || window.webkitAudioContext)();
            const chords = [
                [261.63, 329.63, 392.00, 493.88],
                [220.00, 261.63, 329.63, 392.00],
                [174.61, 220.00, 261.63, 329.63],
                [196.00, 246.94, 293.66, 349.23],
            ];
            let chordIdx = 0;

            function playChord(notes) {
                if (!audioCtx || audioCtx.state === 'suspended') audioCtx.resume();
                notes.forEach((freq) => {
                    const osc = audioCtx.createOscillator();
                    const gain = audioCtx.createGain();
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(freq, audioCtx.currentTime);
                    gain.gain.setValueAtTime(0.001, audioCtx.currentTime);
                    gain.gain.exponentialRampToValueAtTime(0.04, audioCtx.currentTime + 1.5);
                    gain.gain.exponentialRampToValueAtTime(0.001, audioCtx.currentTime + 4.5);
                    osc.connect(gain);
                    gain.connect(audioCtx.destination);
                    osc.start();
                    osc.stop(audioCtx.currentTime + 5);
                });
            }

            playChord(chords[chordIdx]);
            synthInterval = setInterval(() => {
                chordIdx = (chordIdx + 1) % chords.length;
                playChord(chords[chordIdx]);
            }, 4000);
        } catch (e) {
            console.log('Audio context not supported');
        }
    }

    function stopAmbientSynth() {
        if (synthInterval) clearInterval(synthInterval);
        if (audioCtx) {
            audioCtx.close();
            audioCtx = null;
        }
    }
}

/* ── 11. Project Cost & Timeline Estimator (Alpine.js helper) */
window.projectEstimator = function(whatsappNumber) {
    return {
        projectType: 'web',
        features: ['auth', 'seo'],
        timeline: 14,
        cost: 3500000,
        types: {
            landing: { name: 'Landing Page & Company Profile', baseCost: 1500000, baseDays: 5, icon: 'bx-layout' },
            web: { name: 'Web Application & Dashboard', baseCost: 3500000, baseDays: 14, icon: 'bx-code-alt' },
            ecommerce: { name: 'E-Commerce & Toko Online', baseCost: 5000000, baseDays: 20, icon: 'bx-shopping-bag' },
            mobile: { name: 'Aplikasi Mobile Android (APK)', baseCost: 4500000, baseDays: 18, icon: 'bxl-android' }
        },
        featureList: {
            auth: { name: 'Autentikasi & Multi-Role Akun', cost: 750000, days: 3, icon: 'bx-user-check' },
            payment: { name: 'Payment Gateway / QRIS / Donasi', cost: 1200000, days: 4, icon: 'bx-credit-card' },
            whatsapp_api: { name: 'Integrasi Notifikasi WhatsApp', cost: 800000, days: 3, icon: 'bxl-whatsapp' },
            seo: { name: 'Optimasi SEO & Kecepatan Super', cost: 500000, days: 2, icon: 'bx-rocket' },
            ui_custom: { name: 'Desain UI/UX Khusus & Animasi 3D', cost: 1000000, days: 4, icon: 'bx-palette' },
            rest_api: { name: 'RESTful API & Cloud Database', cost: 1200000, days: 4, icon: 'bx-data' }
        },
        toggleFeature(key) {
            if (this.features.includes(key)) {
                this.features = this.features.filter(f => f !== key);
            } else {
                this.features.push(key);
            }
            this.calculate();
        },
        calculate() {
            let selected = this.types[this.projectType];
            let totalCost = selected.baseCost;
            let totalDays = selected.baseDays;
            
            this.features.forEach(f => {
                if (this.featureList[f]) {
                    totalCost += this.featureList[f].cost;
                    totalDays += this.featureList[f].days;
                }
            });
            this.cost = totalCost;
            this.timeline = totalDays;
        },
        formatRupiah(num) {
            return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(num);
        },
        getWhatsAppLink() {
            let typeName = this.types[this.projectType].name;
            let featureNames = this.features.map(f => this.featureList[f]?.name).filter(Boolean).join(', ');
            let text = `Halo Syafiq! Saya tertarik untuk bekerjasama membuat projek melalui website portofolio Anda:\n\n` +
                       `📌 *Jenis Projek:* ${typeName}\n` +
                       `✨ *Fitur Dipilih:* ${featureNames || 'Standar'}\n` +
                       `⏱️ *Estimasi Waktu:* ±${this.timeline} Hari Kerja\n` +
                       `💰 *Estimasi Investasi:* ${this.formatRupiah(this.cost)}\n\n` +
                       `Bisa kita diskusikan lebih lanjut? Terima kasih!`;
            let cleanPhone = (whatsappNumber || '').replace(/[^0-9]/g, '');
            if (cleanPhone.startsWith('0')) cleanPhone = '62' + cleanPhone.slice(1);
            if (!cleanPhone) cleanPhone = '6281234567890';
            return `https://wa.me/${cleanPhone}?text=${encodeURIComponent(text)}`;
        }
    };
};
