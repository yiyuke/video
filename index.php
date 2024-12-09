<?php
session_start();
require_once 'config/database.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VideoLingo - Video Translation Made Easy</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="logo">
            <img src="images/logo.jpg" alt="MediaLingo Logo">
            <span>VideoLingo</span>
        </div>
        <div class="nav-links">
            <a href="#pricing">Pricing</a>
            <a href="#about">About</a>
            <?php if (isset($_SESSION['user_id'])): 
                $stmt = $pdo->prepare("SELECT profile_image FROM users WHERE id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $user = $stmt->fetch();
            ?>
                <a href="dashboard.php">Dashboard</a>
                <a href="settings.php" class="nav-user-info">
                    <img src="<?php echo $user['profile_image'] ?? 'images/default.png'; ?>" alt="Profile">
                    <span><?php echo $_SESSION['username']; ?></span>
                </a>
            <?php else: ?>
                <a href="login.php">Login</a>
                <a href="signup.php">Sign Up</a>
            <?php endif; ?>
        </div>
    </nav>

    <!-- Main Content -->
    <main>
        <!-- Hero Section -->
        <section class="hero">
            <h1>Connecting the World<br>Frame by Frame</h1>
            <p>All-in-one video translation and dubbing tool</p>
            <div class="hero-buttons">
                <a href="<?php echo isset($_SESSION['user_id']) ? 'dashboard.php' : 'signup.php'; ?>" 
                class="primary-btn">Get started</a>
                <a href="#pricing" class="secondary-btn">Find your plan</a>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features">
            <h2>Single-line subtitles only,<br>superior translation quality!</h2>
            <div class="feature-grid">
                <div class="feature-card">
                    <img src="images/cultural.png" alt="Cultural">
                    <h3>Cultural Localization</h3>
                    <p>Deliver translations with authentic expressions and cultural nuances.</p>
                </div>
                <div class="feature-card">
                    <img src="images/expertise.png" alt="Expertise">
                    <h3>Domain Expertise</h3>
                    <p>Accurately translate field-specific terminology to maintain professional.</p>
                </div>
                <div class="feature-card">
                    <img src="images/readable.png" alt="Readable">
                    <h3>Enhanced Readability</h3>
                    <p>Single-line subtitles with precise timing and proper segmentation.</p>
                </div>
            </div>
        </section>

        <section class="features">
            <div class="feature-grid">
                <div class="feature-card">
                    <img src="images/voice.png" alt="Voice">
                    <h3>Natural Voice Synthesis</h3>
                    <p>Intelligent dubbing with the original's emotional tone and speaking style.</p>
                </div>
                <div class="feature-card">
                    <img src="images/process.png" alt="Process">
                    <h3>Streamlined Processing</h3>
                    <p>Fast and efficient content transformation pipeline.<br>A few clicks, all set!</p>
                </div>
                <div class="feature-card">
                    <img src="images/global.png" alt="Global">
                    <h3>Global Accessibility</h3>
                    <p>Support 8+ languages to facilitate global knowledge exchange.</p>
                </div>
            </div>
        </section>

        <!-- Open Source Section -->
        <section class="open-source">
            <h2>And, we keep it open source.</h2>
            <p>VideoLingo got 8k⭐ in 4 months</p>
            <a href="https://github.com/Huanshere/VideoLingo" class="github-btn">
                <img src="images/github.png" alt="GitHub">
                Check us on Github
            </a>
            <div class="contributors">
                <img src="images/contributor-1.png" alt="Contributor">
                <img src="images/contributor-2.png" alt="Contributor">
                <img src="images/contributor-3.png" alt="Contributor">
                <img src="images/contributor-4.png" alt="Contributor">
                <img src="images/contributor-5.png" alt="Contributor">
                <img src="images/contributor-6.png" alt="Contributor">
                <img src="images/contributor-7.png" alt="Contributor">
                <img src="images/contributor-8.png" alt="Contributor">
                <!-- ... More Contributor Avatars ... -->
            </div>
        </section>

        <!-- Testimonials Section -->
        <section class="testimonials">
            <h2>People <span class="heart">❤️</span> VideoLingo</h2>
            <div class="testimonial-container">
                <div class="testimonial-track">
                    <!-- Place all cards in one container -->
                    <div class="testimonial-grid">
                        <!-- Jimmy's Card -->
                        <div class="testimonial-card">
                            <div class="user-info">
                                <img src="images/user-1.png" alt="User">
                                <div>
                                    <h4>Jimmy</h4>
                                    <p>Influencer</p>
                                </div>
                                <img src="images/instagram.png" alt="Instagram" class="social-icon">
                            </div>
                            <p class="testimonial-text">It used to take a whole day, now it's done in an hour! And I posted it just for fun after work at first, didn't expect it to blow up.✌️</p>
                            <p class="date">Sep 20, 2024</p>
                        </div>

                        <div class="testimonial-card">
                            <div class="user-info">
                                <img src="images/user-2.png" alt="User">
                                <div>
                                    <h4>Sarah</h4>
                                    <p>Content Creator</p>
                                </div>
                                <img src="images/youtube.png" alt="YouTube" class="social-icon">
                            </div>
                            <p class="testimonial-text">Translated my cooking tutorials into Japanese. Single-line subtitles look amazing, international audience up 30%!🌍</p>
                            <p class="date">Aug 24, 2024</p>
                        </div>

                        <div class="testimonial-card">
                            <div class="user-info">
                                <img src="images/user-3.png" alt="User">
                                <div>
                                    <h4>Isabella</h4>
                                    <p>Travel Vlogger</p>
                                </div>
                                <img src="images/tiktok.png" alt="TikTok" class="social-icon">
                            </div>
                            <p class="testimonial-text">From 50K to 200K subs after using VideoLingo for my travel content. Perfect timing on translations!✨</p>
                            <p class="date">Oct 05, 2024</p>
                        </div>

                        <div class="testimonial-card">
                            <div class="user-info">
                                    <img src="images/user-7.png" alt="User">
                                    <div>
                                        <h4>Fiona</h4>
                                        <p>Language Teacher</p>
                                    </div>
                                    <img src="images/twitter.png" alt="Twitter" class="social-icon">
                                </div>
                                <p class="testimonial-text">Perfect for my Russian lessons. Catches language nuances others miss. Keeps my teaching style intact!</p>
                                <p class="date">Oct 11, 2024</p>
                            </div>

                        <div class="testimonial-card">
                            <div class="user-info">
                                <img src="images/user-4.png" alt="User">
                                <div>
                                    <h4>David</h4>
                                    <p>Tech Reviewer</p>
                                </div>
                                <img src="images/reddit.png" alt="Reddit" class="social-icon">
                            </div>
                            <p class="testimonial-text">Tested all translation tools, VideoLingo wins. Single-line subs and voice cloning are game-changing. Super easy setup.</p>
                            <p class="date">Oct 21, 2024</p>
                        </div>

                        <div class="testimonial-card">
                            <div class="user-info">
                                <img src="images/user-5.png" alt="User">
                                <div>
                                    <h4>Marcus</h4>
                                    <p>Ed Tech Specialist</p>
                                </div>
                                <img src="images/twitter.png" alt="Twitter" class="social-icon">
                            </div>
                            <p class="testimonial-text">Used to spend weeks on course. Now VideoLingo does it all in hours. The translations actually understand context!🤓</p>
                            <p class="date">Aug 19, 2024</p>
                        </div>

                        <div class="testimonial-card">
                            <div class="user-info">
                                <img src="images/user-6.png" alt="User">
                                <div>
                                    <h4>Yuki</h4>
                                    <p>Filmmaker</p>
                                </div>
                                <img src="images/youtube.png" alt="YouTube" class="social-icon">
                            </div>
                            <p class="testimonial-text">The Best AI tool I've found! Used it in my documentary. Voice separation handled background music perfectly!</p>
                            <p class="date">Sep 28, 2024</p>
                        </div>

                        <div class="testimonial-card">
                            <div class="user-info">
                                <img src="images/user-8.png" alt="User">
                                <div>
                                    <h4>Aisha</h4>
                                    <p>Marketing Lead</p>
                                </div>
                                <img src="images/linkedin.png" alt="LinkedIn" class="social-icon">
                            </div>
                            <p class="testimonial-text">Turned our content into 6 languages. Engagement up 300%. Netflix-quality subs make us look pro!🚀</p>
                            <p class="date">Sep 13, 2024</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <div class="footer-section">
                <h4>PRODUCT</h4>
                <a href="#pricing">Pricing</a>
                <a href="#whats-new">What's new</a>
            </div>
            <div class="footer-section">
                <h4>COMPANY</h4>
                <a href="#about">About</a>
                <a href="#contact">Contact us</a>
            </div>
            <div class="footer-section">
                <h4>LEGAL</h4>
                <a href="#privacy">Privacy</a>
                <a href="#terms">Terms</a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 MediaLingo. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>