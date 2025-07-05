
import AOS from 'aos';
import 'aos/dist/aos.css';

 document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 800,
                once: true,
            });

            // Particle effect
            function createParticles() {
                const particlesContainer = document.getElementById('particles');
                const numberOfParticles = 50;

                for (let i = 0; i < numberOfParticles; i++) {
                    const particle = document.createElement('div');
                    particle.className = 'particle';
                    
                    // Random position
                    particle.style.left = Math.random() * 100 + '%';
                    particle.style.top = Math.random() * 100 + '%';
                    
                    // Random size
                    const size = Math.random() * 3;
                    particle.style.width = size + 'px';
                    particle.style.height = size + 'px';
                    
                    // Random opacity
                    particle.style.opacity = Math.random() * 0.5 + 0.2;
                    
                    // Animation
                    particle.style.animation = `floating ${Math.random() * 3 + 2}s ease-in-out infinite`;
                    particle.style.animationDelay = `${Math.random() * 2}s`;
                    
                    particlesContainer.appendChild(particle);
                }
            }

            // Create particles
            createParticles();

            const roleSelect = document.getElementById('role');
            const pelaksanaFields = document.getElementById('pelaksanaFields');

            roleSelect.addEventListener('change', function() {
                if (this.value === 'pelaksana') {
                    pelaksanaFields.classList.remove('hidden');
                    setTimeout(() => {
                        pelaksanaFields.style.opacity = '1';
                    }, 50);
                    // Make fields required when visible
                    document.getElementById('unit_kerja').required = true;
                    document.getElementById('jabatan_fungsional').required = true;
                } else {
                    pelaksanaFields.style.opacity = '0';
                    setTimeout(() => {
                    pelaksanaFields.classList.add('hidden');
                    }, 300);
                    // Remove required when hidden
                    document.getElementById('unit_kerja').required = false;
                    document.getElementById('jabatan_fungsional').required = false;
                }
            });

            // Add hover effect to form inputs
            const inputs = document.querySelectorAll('.form-input');
            inputs.forEach(input => {
                input.addEventListener('focus', () => {
                    input.classList.add('glow');
                });
                input.addEventListener('blur', () => {
                    input.classList.remove('glow');
                });
            });

            // Initialize theme from localStorage
            const savedTheme = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', savedTheme);
            document.body.classList.remove('light', 'dark');
            document.body.classList.add(savedTheme);

            // Listen for theme changes
            window.addEventListener('themeChanged', function(e) {
                const newTheme = e.detail;
                document.documentElement.setAttribute('data-theme', newTheme);
                document.body.classList.remove('light', 'dark');
                document.body.classList.add(newTheme);
            });
        });