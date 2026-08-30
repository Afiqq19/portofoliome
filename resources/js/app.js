/**
 * Portfolio Next-Gen Interactive Experience Engine
 * Features:
 * 1. Constellation Particle Canvas with Mouse Interactivity
 * 2. 3D Tilt Cards & Mouse Spotlight Illumination
 * 3. Dynamic Role Typewriter Engine (Resilient Selector)
 * 4. Animated Number Counters (Viewport Triggered)
 * 5. Animated Skill Progress Bars
 * 6. Floating Back-to-Top with Circular Progress Ring
 * 7. Interactive Project Category Filtering
 * 8. Scroll Reveal Observer
 * 9. Navbar Scroll Visual Effect
 * 10. Lo-Fi Ambient Audio Player & Equalizer
 * 11. Interactive Project Cost & Timeline Estimator (Alpine Helper)
 * 12. Instant Copy-to-Clipboard with Toast Notification
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
    initClipboardHelper();
});

/* ── 1. Constellation Particle Canvas ─────────────────────── */
function initConstellationCanvas() {
    const canvas = document.getElementById('bg-canvas');
    if (!canvas) return;

    const ctx = canvas.getContext('2d');
    let width = (canvas.width = window.innerWidth);
    let height = (canvas.height = window.innerHeight);

    let particles = [];
    const particleCount = Math.min(Math.floor((width * height) / 13000), 80);
    const connectionDistance = 140;
    const mouseConnectionDistance = 180;

    let mouse = {
        x: null,
        y: null,
        radius: 160,
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
                const rotateX = ((y - centerY) / centerY) * -6;
                const rotateY = ((x - centerX) / centerX) * 6;
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
    const typewriterEl = document.getElementById('role-typewriter') || document.getElementById('typewriter-role') || document.querySelector('.typewriter-text');
    if (!typewriterEl) return;

    let roles = ['Full Stack Web Developer', 'Creative UI/UX Enthusiast', 'Mobile App Engineer', 'Modern Tech Architect'];

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
            typingSpeed = 85;
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

    type();
}

/* ── 4. Animated Number Counters ─────────────────────────── */
function initNumberCounters() {
    const counters = document.querySelectorAll('.stat-counter');
    if (!counters.length) return;

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const target = parseInt(entry.target.getAttribute('data-target') || '0', 10);
                animateValue(entry.target, 0, target, 1600);
                obs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.2 });

    counters.forEach((counter) => observer.observe(counter));

    function animateValue(obj, start, end, duration) {
        if (start === end) {
            obj.textContent = end;
            return;
        }
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
            // Ease out quad
            const easeProgress = 1 - (1 - progress) * (1 - progress);
            obj.textContent = Math.floor(easeProgress * (end - start) + start);
            if (progress < 1) {
                window.requestAnimationFrame(step);
            } else {
                obj.textContent = end;
            }
        };
        window.requestAnimationFrame(step);
    }
}

/* ── 5. Animated Skill Progress Bars ─────────────────────── */
function initSkillProgressBars() {
    const progressBars = document.querySelectorAll('.skill-progress-bar');
    if (!progressBars.length) return;

    const observer = new IntersectionObserver((entries, obs) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                const target = entry.target.getAttribute('data-progress') || '0';
                entry.target.style.width = `${target}%`;
                obs.unobserve(entry.target);
            }
        });
    }, { threshold: 0.1 });

    progressBars.forEach((bar) => observer.observe(bar));
}

/* ── 6. Floating Back to Top Button with Circular Progress ── */
function initBackToTop() {
    const backToTopBtn = document.getElementById('back-to-top');
    const circle = document.getElementById('progress-ring-circle');
    if (!backToTopBtn) return;

    const circumference = 2 * Math.PI * 22; // r=22 -> ~138.2
    if (circle) {
        circle.style.strokeDasharray = `${circumference}`;
        circle.style.strokeDashoffset = `${circumference}`;
    }

    window.addEventListener('scroll', () => {
        const scrollTop = window.scrollY || document.documentElement.scrollTop;
        const scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrollProgress = scrollHeight > 0 ? scrollTop / scrollHeight : 0;

        if (scrollTop > 300) {
            backToTopBtn.classList.add('visible');
        } else {
            backToTopBtn.classList.remove('visible');
        }

        if (circle) {
            const offset = circumference - scrollProgress * circumference;
            circle.style.strokeDashoffset = offset;
        }
    });

    backToTopBtn.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth',
        });
    });
}

/* ── 7. Interactive Project Category Filtering ───────────── */
function initProjectFilters() {
    const filterButtons = document.querySelectorAll('[data-filter]');
    const projectCards = document.querySelectorAll('[data-category]');

    if (!filterButtons.length || !projectCards.length) return;

    filterButtons.forEach((btn) => {
        btn.addEventListener('click', () => {
            filterButtons.forEach((b) => b.classList.remove('active'));
            btn.classList.add('active');

            const filterValue = btn.getAttribute('data-filter');

            projectCards.forEach((card) => {
                const categories = card.getAttribute('data-category').split(' ');
                if (filterValue === 'all' || categories.includes(filterValue)) {
                    card.style.display = 'flex';
                    setTimeout(() => {
                        card.style.opacity = '1';
                        card.style.transform = 'scale(1)';
                    }, 50);
                } else {
                    card.style.opacity = '0';
                    card.style.transform = 'scale(0.95)';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 250);
                }
            });
        });
    });
}

/* ── 8. Scroll Reveal Observer ───────────────────────────── */
function initScrollReveal() {
    const reveals = document.querySelectorAll('.reveal');
    if (!reveals.length) return;

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px',
    });

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
    });
}

/* ── 10. Lo-Fi Ambient Audio Player & Equalizer ───────────── */
function initLofiPlayer() {
    const toggleBtn = document.getElementById('lofi-toggle');
    const audio = document.getElementById('lofi-audio');
    const widget = document.getElementById('lofi-widget');
    if (!toggleBtn || !audio || !widget) return;

    let isPlaying = false;

    function setPlayingState() {
        isPlaying = true;
        widget.classList.add('lofi-playing');
        toggleBtn.innerHTML = "<i class='bx bx-pause text-xl'></i>";
        toggleBtn.classList.remove('bg-indigo-600');
        toggleBtn.classList.add('bg-emerald-600');
    }

    function setPausedState() {
        isPlaying = false;
        widget.classList.remove('lofi-playing');
        toggleBtn.innerHTML = "<i class='bx bx-play text-xl'></i>";
        toggleBtn.classList.remove('bg-emerald-600');
        toggleBtn.classList.add('bg-indigo-600');
    }

    function playAudio() {
        if (isPlaying) return;
        const playPromise = audio.play();
        if (playPromise !== undefined) {
            playPromise.then(() => {
                setPlayingState();
                removeAutoPlayListeners();
            }).catch(() => {
                // Browser prevented unmuted auto-playback until first gesture
                setPausedState();
            });
        }
    }

    // 1. Attempt immediate autoplay on page load
    playAudio();

    // 2. Fallback: play instantly on first user interaction anywhere on the screen
    function onFirstInteraction() {
        if (!isPlaying) {
            playAudio();
        }
        removeAutoPlayListeners();
    }

    const interactionEvents = ['click', 'touchstart', 'scroll', 'keydown', 'mousemove'];
    function removeAutoPlayListeners() {
        interactionEvents.forEach((evt) => {
            window.removeEventListener(evt, onFirstInteraction);
            document.removeEventListener(evt, onFirstInteraction);
        });
    }

    interactionEvents.forEach((evt) => {
        window.addEventListener(evt, onFirstInteraction, { once: true, passive: true });
        document.addEventListener(evt, onFirstInteraction, { once: true, passive: true });
    });

    toggleBtn.addEventListener('click', (e) => {
        e.stopPropagation();
        if (isPlaying) {
            audio.pause();
            setPausedState();
        } else {
            audio.play().then(() => {
                setPlayingState();
            }).catch((err) => {
                console.log('Audio playback error:', err);
            });
        }
    });
}

/* ── 11. Interactive Project Cost & Timeline Estimator (Alpine Helper) ── */
window.projectEstimator = function (phone = '') {
    return {
        phone: phone,
        projectType: 'web_company',
        features: ['responsive', 'seo'],
        urgency: 'normal',
        
        types: {
            landing_page: {
                name: 'Landing Page / Promosi',
                baseCost: 1500000,
                baseDays: 5,
                icon: 'bx-layout',
                desc: 'Halaman promosi tunggal dengan konversi tinggi & desain modern.',
            },
            web_company: {
                name: 'Company Profile & Bisnis',
                baseCost: 3500000,
                baseDays: 10,
                icon: 'bx-buildings',
                desc: 'Website representasi perusahaan dengan halaman profil, layanan & kontak.',
            },
            e_commerce: {
                name: 'Toko Online & E-Commerce',
                baseCost: 6500000,
                baseDays: 18,
                icon: 'bx-cart-alt',
                desc: 'Katalog produk, keranjang belanja, checkout & integrasi payment gateway.',
            },
            web_app: {
                name: 'Custom Web Application / SaaS',
                baseCost: 9000000,
                baseDays: 25,
                icon: 'bx-laptop',
                desc: 'Sistem manajemen custom, database kompleks, otentikasi role & API.',
            },
            mobile_app: {
                name: 'Mobile App (Android APK / Flutter)',
                baseCost: 8000000,
                baseDays: 21,
                icon: 'bxl-android',
                desc: 'Aplikasi mobile Android responsif dengan integrasi backend RESTful API.',
            },
        },

        featureList: {
            responsive: { name: 'Desain Responsif Mobile/Tablet', cost: 500000, days: 1, icon: 'bx-mobile-alt' },
            seo: { name: 'Optimasi SEO & Google Search', cost: 750000, days: 2, icon: 'bx-search-alt' },
            auth: { name: 'Sistem Login & Multi-Role Akun', cost: 1200000, days: 4, icon: 'bx-lock-alt' },
            payment: { name: 'Payment Gateway (QRIS, E-Wallet)', cost: 1800000, days: 4, icon: 'bx-credit-card' },
            whatsapp: { name: 'Integrasi Otomatisasi WhatsApp API', cost: 1000000, days: 3, icon: 'bxl-whatsapp' },
            admin_panel: { name: 'Admin Dashboard Pengelolaan Konten', cost: 2000000, days: 5, icon: 'bx-slider' },
            dark_mode: { name: 'Tema Gelap / Terang (Dark Mode)', cost: 400000, days: 1, icon: 'bx-moon' },
            multilingual: { name: 'Dukungan Multi-Bahasa (ID/EN)', cost: 800000, days: 2, icon: 'bx-globe' },
        },

        totalCost: 0,
        totalDays: 0,

        init() {
            this.calculate();
        },

        toggleFeature(key) {
            if (this.features.includes(key)) {
                this.features = this.features.filter((f) => f !== key);
            } else {
                this.features.push(key);
            }
            this.calculate();
        },

        calculate() {
            const currentType = this.types[this.projectType] || this.types.web_company;
            let cost = currentType.baseCost;
            let days = currentType.baseDays;

            this.features.forEach((fKey) => {
                if (this.featureList[fKey]) {
                    cost += this.featureList[fKey].cost;
                    days += this.featureList[fKey].days;
                }
            });

            if (this.urgency === 'express') {
                cost *= 1.25;
                days = Math.max(Math.round(days * 0.65), 3);
            }

            this.totalCost = Math.round(cost);
            this.totalDays = days;
        },

        formatRupiah(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                maximumFractionDigits: 0,
            }).format(amount);
        },

        getWhatsAppUrl() {
            const cleanPhone = this.phone.replace(/[^0-9]/g, '');
            const targetPhone = cleanPhone.startsWith('0') ? '62' + cleanPhone.slice(1) : (cleanPhone.startsWith('62') ? cleanPhone : '6281234567890');
            
            const typeName = this.types[this.projectType]?.name || 'Custom Project';
            const selectedFeaturesNames = this.features.map((f) => this.featureList[f]?.name).filter(Boolean).join(', ');
            
            const message = `Halo MSyafiq! 👋\n\nSaya ingin berkonsultasi mengenai pembuatan projek dengan estimasi berikut:\n\n` +
                `📌 *Kategori Projek:* ${typeName}\n` +
                `⚙️ *Fitur yang Dibutuhkan:* ${selectedFeaturesNames || '-'}\n` +
                `⏱️ *Perkiraan Waktu:* ± ${this.totalDays} Hari Kerja (${this.urgency === 'express' ? 'Prioritas Express' : 'Reguler'})\n` +
                `💰 *Estimasi Investasi:* ${this.formatRupiah(this.totalCost)}\n\n` +
                `Apakah kita bisa berdiskusi lebih lanjut mengenai jadwal pengerjaannya? Terima kasih!`;

            return `https://wa.me/${targetPhone}?text=${encodeURIComponent(message)}`;
        }
    };
};

/* ── 12. Instant Copy-to-Clipboard with Toast Notification ── */
function initClipboardHelper() {
    window.copyToClipboard = function (text, message = 'Teks berhasil disalin!') {
        if (!text) return;
        navigator.clipboard.writeText(text).then(() => {
            showToast(message);
        }).catch(() => {
            // Fallback
            const el = document.createElement('textarea');
            el.value = text;
            document.body.appendChild(el);
            el.select();
            document.execCommand('copy');
            document.body.removeChild(el);
            showToast(message);
        });
    };

    function showToast(msg) {
        let toast = document.getElementById('global-toast');
        if (!toast) {
            toast = document.createElement('div');
            toast.id = 'global-toast';
            toast.className = 'fixed bottom-6 right-6 z-[9999] bg-indigo-600 text-white font-bold text-xs py-3 px-5 rounded-2xl shadow-2xl flex items-center gap-2 border border-white/20 transform transition-all duration-300 translate-y-10 opacity-0';
            document.body.appendChild(toast);
        }

        toast.innerHTML = `<i class='bx bx-check-circle text-lg text-emerald-300'></i><span>${msg}</span>`;
        toast.classList.remove('translate-y-10', 'opacity-0');
        toast.classList.add('translate-y-0', 'opacity-100');

        setTimeout(() => {
            toast.classList.remove('translate-y-0', 'opacity-100');
            toast.classList.add('translate-y-10', 'opacity-0');
        }, 2800);
    }
}
