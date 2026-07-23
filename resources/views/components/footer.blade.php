@props([
    'columns' => [
        'Quick Links' => [
            ['/', 'Home'],
            ['/companies', 'Verified Companies'],
            ['#', 'Pricing Plans'],
        ],
        'Candidates' => [
            ['/jobs', 'Browse Jobs'],
            ['#', 'Career Advice'],
            ['#', 'Salary Guide'],
        ],
        'Employers' => [
            ['#', 'Post a Job'],
            ['#', 'Pricing'],
            ['#', 'Talent Search'],
        ],
    ],
])

<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-grid">
            <div class="footer-brand">
                <a href="/" class="footer-logo">
                    <span class="footer-logo-icon">J</span>
                    <span class="footer-logo-text">
                        JOBZ IN <span class="footer-logo-accent">CANADA</span>
                    </span>
                </a>
                <p class="footer-tagline">
                    Canada's premier job board connecting top talent with leading employers nationwide.
                </p>
                <div class="footer-contact">
                    <span>📍 250 Yonge St, Toronto, ON</span>
                    <span>📧 support@jobzincanada.ca</span>
                </div>
            </div>

            <div class="footer-section">
                @foreach($columns as $heading => $links)
                    <div class="footer-col">
                        <h4>{{ $heading }}</h4>
                        <ul>
                            @foreach($links as [$href, $label])
                                <li>
                                    <a href="{{ $href }}">{{ $label }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>

            <div class="footer-social">
                <h4>Connect</h4>
                <div class="social-links">
                    <a href="#" title="LinkedIn" class="social-btn">LN</a>
                    <a href="#" title="Twitter" class="social-btn">TW</a>
                    <a href="#" title="Facebook" class="social-btn">FB</a>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <div class="footer-bottom-inner">
            <p>&copy; {{ date('Y') }} JOBZ IN CANADA. All rights reserved.</p>
            <div class="footer-bottom-links">
                @foreach(['Privacy Policy', 'Terms of Service', 'Cookies'] as $link)
                    <a href="#">{{ $link }}</a>
                @endforeach
            </div>
        </div>
    </div>
</footer>
