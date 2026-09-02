<?php
/**
 * iThrive AI - Final CTA & RFP Consultation Form Section
 * Path: sections/cta-contact.php
 */
?>
<section id="contact" class="section-padding">
    <div class="container">
        <div class="contact-section-wrap corner-bracket-wrap">
            <div class="corner-bracket-bottom-left"></div>
            <div class="corner-bracket-bottom-right"></div>

            <div class="contact-layout">
                <!-- Left Column: Value Proposition & Contact Info -->
                <div>
                    <div class="section-tag">
                        <span class="dot"></span>
                        <span>START YOUR PROJECT</span>
                    </div>
                    <h2 style="font-size: clamp(2rem, 3.5vw, 2.75rem); margin-bottom: 1.25rem;">
                        Ready to Build Your <br>
                        <span class="text-gradient">Custom AI Platform?</span>
                    </h2>
                    <p style="font-size: 1.05rem; color: var(--text-secondary); line-height: 1.6; margin-bottom: 2.5rem;">
                        Schedule a confidential 45-minute AI Architecture Discovery Call with our senior engineering architects. We provide an actionable technical blueprint and estimate.
                    </p>

                    <!-- Trust Points -->
                    <div style="display: flex; flex-direction: column; gap: 1.25rem; margin-bottom: 2.5rem;">
                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(34, 211, 238, 0.12); border: 1px solid rgba(34, 211, 238, 0.3); color: var(--accent-cyan); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                                <i class="fa-solid fa-file-signature"></i>
                            </div>
                            <div>
                                <div style="font-weight: 700; color: #FFF; font-size: 0.95rem;">100% Strict NDA Protection</div>
                                <div style="font-size: 0.82rem; color: var(--text-muted);">Bilateral non-disclosure signed before technical review.</div>
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(59, 94, 253, 0.12); border: 1px solid rgba(59, 94, 253, 0.3); color: var(--accent-blue); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                                <i class="fa-solid fa-bolt"></i>
                            </div>
                            <div>
                                <div style="font-weight: 700; color: #FFF; font-size: 0.95rem;">Rapid 24-Hour Response</div>
                                <div style="font-size: 0.82rem; color: var(--text-muted);">Direct consultation with Lead AI Solutions Architects.</div>
                            </div>
                        </div>

                        <div style="display: flex; align-items: center; gap: 1rem;">
                            <div style="width: 40px; height: 40px; border-radius: 10px; background: rgba(217, 70, 239, 0.12); border: 1px solid rgba(217, 70, 239, 0.3); color: var(--accent-magenta); display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                                <i class="fa-solid fa-diagram-project"></i>
                            </div>
                            <div>
                                <div style="font-weight: 700; color: #FFF; font-size: 0.95rem;">Complimentary Architecture Blueprint</div>
                                <div style="font-size: 0.82rem; color: var(--text-muted);">Receive a free feasibility roadmap and tech stack proposal.</div>
                            </div>
                        </div>
                    </div>

                    <!-- Direct Contact -->
                    <div style="border-top: 1px solid rgba(255, 255, 255, 0.08); padding-top: 1.5rem;">
                        <div style="font-size: 0.9rem; color: var(--text-secondary);">
                            <i class="fa-solid fa-envelope" style="color: var(--accent-cyan); margin-right: 0.5rem;"></i>
                            <a href="mailto:info@ithrive.ai" style="color: #FFF; font-weight: 600;">info@ithrive.ai</a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Interactive Consultation RFP Form -->
                <div>
                    <form id="ai-consultation-form" enctype="multipart/form-data" method="POST">
                        <!-- Honeypot -->
                        <input type="text" name="website_hp" style="display: none !important;" tabindex="-1" autocomplete="off">

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                            <div class="form-group">
                                <label class="form-label" for="rfp-name">Full Name *</label>
                                <input type="text" id="rfp-name" name="fullname" class="form-control" placeholder="e.g. Anand Kumar" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="rfp-email">Business Email *</label>
                                <input type="email" id="rfp-email" name="email" class="form-control" placeholder="anand@company.com" required>
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                            <div class="form-group">
                                <label class="form-label" for="rfp-phone">Phone / WhatsApp *</label>
                                <input type="tel" id="rfp-phone" name="phone" class="form-control" placeholder="+91 98765 43210" required>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="rfp-company">Company / Organization</label>
                                <input type="text" id="rfp-company" name="company" class="form-control" placeholder="e.g. Acme Corp">
                            </div>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem;">
                            <div class="form-group">
                                <label class="form-label" for="rfp-service">Primary AI Requirement</label>
                                <select id="rfp-service" name="service" class="form-control">
                                    <option value="Generative AI & LLMs">Custom LLMs &amp; Enterprise RAG</option>
                                    <option value="Autonomous AI Agents">Autonomous AI Agents &amp; Co-Pilots</option>
                                    <option value="Conversational AI & Voicebots">Multilingual Voice &amp; Chatbots</option>
                                    <option value="Computer Vision & OCR">Computer Vision, OCR &amp; Video AI</option>
                                    <option value="Enterprise AI Integration">Enterprise System AI Integration</option>
                                    <option value="Predictive Analytics & BI">Predictive Analytics &amp; Forecasting</option>
                                    <option value="AI Security & Compliance">AI Governance &amp; Security Audit</option>
                                    <option value="Full-Stack AI Product SaaS">Custom AI Product Development</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="rfp-budget">Expected Project Budget</label>
                                <select id="rfp-budget" name="budget" class="form-control">
                                    <option value="$15k - $30k (₹12L - ₹25L)">$15,000 – $30,000 (MVP / PoC)</option>
                                    <option value="$30k - $75k (₹25L - ₹60L)" selected>$30,000 – $75,000 (Core Platform)</option>
                                    <option value="$75k - $150k (₹60L - ₹1.2Cr)">$75,000 – $150,000 (Enterprise AI)</option>
                                    <option value="$150k+ (₹1.2Cr+)">$150,000+ (Multi-Model System)</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="rfp-message">Project Brief &amp; Technical Objectives</label>
                            <textarea id="rfp-message" name="message" class="form-control" placeholder="Describe your data sources, expected model capabilities, and target timeline..."></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="rfp-attachment">
                                Attach Technical Specs / RFP Document <span style="font-weight: 400; color: var(--text-muted);">(Optional - PDF, DOCX, up to 10MB)</span>
                            </label>
                            <input type="file" id="rfp-attachment" name="attachment" class="form-control" style="padding: 0.6rem 1rem;">
                        </div>

                        <button type="submit" class="btn btn-primary btn-lg" style="width: 100%; margin-top: 0.5rem;">
                            <span>Submit AI Architecture Consultation Request</span>
                            <i class="fa-solid fa-arrow-right"></i>
                        </button>

                        <div id="form-feedback-message"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
