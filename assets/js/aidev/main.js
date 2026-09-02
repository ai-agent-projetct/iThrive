/**
 * iThrive AI - Master Interactive JavaScript
 */

document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  // -------------------------------------------------------------
  // 1. Sticky Header & Active State
  // -------------------------------------------------------------
  const header = document.querySelector('.site-header');
  window.addEventListener('scroll', function () {
    if (window.scrollY > 40) {
      header?.classList.add('scrolled');
    } else {
      header?.classList.remove('scrolled');
    }
  });

  // Mobile menu toggle
  const mobileToggle = document.querySelector('.mobile-nav-toggle');
  const navMenu = document.querySelector('.nav-menu');
  if (mobileToggle && navMenu) {
    mobileToggle.addEventListener('click', function () {
      const isVisible = navMenu.style.display === 'flex';
      navMenu.style.display = isVisible ? 'none' : 'flex';
      navMenu.style.flexDirection = 'column';
      navMenu.style.position = 'absolute';
      navMenu.style.top = '100%';
      navMenu.style.left = '0';
      navMenu.style.width = '100%';
      navMenu.style.background = 'rgba(11, 14, 28, 0.98)';
      navMenu.style.padding = '2rem';
      navMenu.style.borderBottom = '1px solid rgba(139, 47, 201, 0.3)';
    });
  }

  // -------------------------------------------------------------
  // 2. Action Ticker Crossfade & Typewriter
  // -------------------------------------------------------------
  const tickerEl = document.getElementById('hero-ticker-target');
  const tickerLines = [
    "BUILD A CUSTOM ENTERPRISE LLM & RAG AGENT",
    "AUTOMATE WORKFLOWS WITH MULTIMODAL COMPUTER VISION",
    "DEPLOY INTELLIGENT VOICEBOTS IN 25+ LANGUAGES",
    "TRAIN PREDICTIVE AI MODELS ON PRIVATE CLOUD INFRASTRUCTURE",
    "FINE-TUNE CUSTOM LLMS FOR HEALTHCARE & FINTECH COMPLIANCE",
    "SCALE AUTONOMOUS AI CO-PILOTS FOR ENTERPRISE ERP & CRM"
  ];

  if (tickerEl) {
    let currentIdx = 0;
    setInterval(() => {
      tickerEl.style.opacity = '0';
      tickerEl.style.transform = 'translateY(8px)';
      tickerEl.style.transition = 'all 0.3s ease';

      setTimeout(() => {
        currentIdx = (currentIdx + 1) % tickerLines.length;
        tickerEl.textContent = tickerLines[currentIdx];
        tickerEl.style.opacity = '1';
        tickerEl.style.transform = 'translateY(0)';
      }, 300);
    }, 3800);
  }

  // -------------------------------------------------------------
  // 3. Section 2: OriginKit DragElements Component Controller
  // Exact Framer-Motion DragElements system (Physics, Momentum, bringToFront, Elastic Constraints)
  // -------------------------------------------------------------
  const dragContainer = document.getElementById('drag-elements-container');
  if (dragContainer) {
    const dragItems = Array.from(dragContainer.querySelectorAll('.drag-item'));
    const resetBtn = document.getElementById('reset-drag-btn');

    // State matching React props: selectedOnTop, dragElastic, dragMomentum
    const dragElastic = 0.5;
    const dragMomentum = true;
    const selectedOnTop = true;

    // zIndices array stack
    let zIndices = dragItems.map((_, i) => i);

    function bringToFront(index) {
      if (selectedOnTop) {
        const curPos = zIndices.indexOf(index);
        if (curPos > -1) {
          zIndices.splice(curPos, 1);
          zIndices.push(index);
          dragItems.forEach((item, i) => {
            item.style.zIndex = zIndices.indexOf(i) + 1;
          });
        }
      }
    }

    // Store base layout offsets
    const itemStates = dragItems.map((item, index) => {
      item.style.zIndex = index + 1;
      return {
        el: item,
        index: index,
        x: 0,
        y: 0,
        vx: 0,
        vy: 0,
        isDragging: false,
        initialLeft: item.style.left,
        initialTop: item.style.top,
        animFrame: null
      };
    });

    dragItems.forEach((item, index) => {
      const state = itemStates[index];
      let startPointerX = 0;
      let startPointerY = 0;
      let startX = 0;
      let startY = 0;
      let lastTime = 0;
      let lastPosX = 0;
      let lastPosY = 0;

      function onPointerDown(e) {
        // Prevent default drag behaviors
        e.preventDefault();
        bringToFront(index);

        if (state.animFrame) {
          cancelAnimationFrame(state.animFrame);
          state.animFrame = null;
        }

        state.isDragging = true;
        item.classList.add('is-dragging');
        item.style.cursor = 'grabbing';

        startPointerX = e.clientX;
        startPointerY = e.clientY;
        startX = state.x;
        startY = state.y;
        lastPosX = state.x;
        lastPosY = state.y;
        lastTime = performance.now();
        state.vx = 0;
        state.vy = 0;

        try {
          item.setPointerCapture(e.pointerId);
        } catch (_) {}

        window.addEventListener('pointermove', onPointerMove);
        window.addEventListener('pointerup', onPointerUp);
        window.addEventListener('pointercancel', onPointerUp);
      }

      function onPointerMove(e) {
        if (!state.isDragging) return;

        const now = performance.now();
        const dt = Math.max(1, now - lastTime);

        const deltaX = e.clientX - startPointerX;
        const deltaY = e.clientY - startPointerY;

        let targetX = startX + deltaX;
        let targetY = startY + deltaY;

        // Container constraints & elastic resistance
        const containerRect = dragContainer.getBoundingClientRect();
        const itemRect = item.getBoundingClientRect();

        const currentLeft = item.offsetLeft + targetX;
        const currentTop = item.offsetTop + targetY;

        const minX = -item.offsetLeft;
        const maxX = containerRect.width - item.offsetLeft - itemRect.width;
        const minY = -item.offsetTop;
        const maxY = containerRect.height - item.offsetTop - itemRect.height;

        if (targetX < minX) {
          targetX = minX + (targetX - minX) * dragElastic;
        } else if (targetX > maxX) {
          targetX = maxX + (targetX - maxX) * dragElastic;
        }

        if (targetY < minY) {
          targetY = minY + (targetY - minY) * dragElastic;
        } else if (targetY > maxY) {
          targetY = maxY + (targetY - maxY) * dragElastic;
        }

        state.vx = ((targetX - lastPosX) / dt) * 16.6;
        state.vy = ((targetY - lastPosY) / dt) * 16.6;

        lastPosX = targetX;
        lastPosY = targetY;
        lastTime = now;

        state.x = targetX;
        state.y = targetY;

        // Interactive tilt based on drag speed
        const tilt = Math.max(-6, Math.min(6, state.vx * 0.35));
        item.style.transform = `translate3d(${state.x}px, ${state.y}px, 0) scale(1.04) rotate(${tilt}deg)`;
      }

      function onPointerUp(e) {
        if (!state.isDragging) return;
        state.isDragging = false;
        item.classList.remove('is-dragging');
        item.style.cursor = 'grab';

        try {
          item.releasePointerCapture(e.pointerId);
        } catch (_) {}

        window.removeEventListener('pointermove', onPointerMove);
        window.removeEventListener('pointerup', onPointerUp);
        window.removeEventListener('pointercancel', onPointerUp);

        // Momentum inertia loop & spring boundary recoil
        if (dragMomentum) {
          startMomentumLoop(state, item);
        }
      }

      item.addEventListener('pointerdown', onPointerDown);
    });

    function startMomentumLoop(state, item) {
      const friction = 0.92;
      const springStiffness = 0.12;

      function momentumStep() {
        const containerRect = dragContainer.getBoundingClientRect();
        const itemRect = item.getBoundingClientRect();

        const minX = -item.offsetLeft;
        const maxX = containerRect.width - item.offsetLeft - itemRect.width;
        const minY = -item.offsetTop;
        const maxY = containerRect.height - item.offsetTop - itemRect.height;

        let springForceX = 0;
        let springForceY = 0;

        if (state.x < minX) {
          springForceX = (minX - state.x) * springStiffness;
        } else if (state.x > maxX) {
          springForceX = (maxX - state.x) * springStiffness;
        }

        if (state.y < minY) {
          springForceY = (minY - state.y) * springStiffness;
        } else if (state.y > maxY) {
          springForceY = (maxY - state.y) * springStiffness;
        }

        state.vx = state.vx * friction + springForceX;
        state.vy = state.vy * friction + springForceY;

        state.x += state.vx;
        state.y += state.vy;

        item.style.transform = `translate3d(${state.x}px, ${state.y}px, 0)`;

        if (Math.abs(state.vx) > 0.05 || Math.abs(state.vy) > 0.05 || Math.abs(springForceX) > 0.05 || Math.abs(springForceY) > 0.05) {
          state.animFrame = requestAnimationFrame(momentumStep);
        } else {
          // Clamp cleanly inside bounds
          state.x = Math.max(minX, Math.min(maxX, state.x));
          state.y = Math.max(minY, Math.min(maxY, state.y));
          item.style.transform = `translate3d(${state.x}px, ${state.y}px, 0)`;
          state.animFrame = null;
        }
      }

      if (state.animFrame) cancelAnimationFrame(state.animFrame);
      state.animFrame = requestAnimationFrame(momentumStep);
    }

    // Reset button animation: smoothly spring all cards back to 0,0
    if (resetBtn) {
      resetBtn.addEventListener('click', function () {
        itemStates.forEach((state) => {
          if (state.animFrame) cancelAnimationFrame(state.animFrame);
          state.el.style.transition = 'transform 0.5s cubic-bezier(0.16, 1, 0.3, 1)';
          state.x = 0;
          state.y = 0;
          state.vx = 0;
          state.vy = 0;
          state.el.style.transform = 'translate3d(0, 0, 0)';
          setTimeout(() => {
            state.el.style.transition = '';
          }, 500);
        });
      });
    }
  }

  // -------------------------------------------------------------
  // 4. Video Showcase Modal Handler
  // -------------------------------------------------------------
  const videoModal = document.getElementById('solution-video-modal');
  const videoPlayer = document.getElementById('solution-video-player');
  const videoTitle = document.getElementById('video-modal-title-text');
  const modalCloseBtn = document.querySelector('.video-modal-close');

  window.openVideoModal = function (videoSrc, title) {
    if (!videoModal || !videoPlayer) return;
    videoPlayer.src = videoSrc;
    if (videoTitle) videoTitle.textContent = title || 'Interactive AI Solution Preview';
    videoModal.classList.add('active');
    videoPlayer.play().catch(() => {});
  };

  window.closeVideoModal = function () {
    if (!videoModal || !videoPlayer) return;
    videoModal.classList.remove('active');
    videoPlayer.pause();
    videoPlayer.currentTime = 0;
  };

  if (modalCloseBtn) {
    modalCloseBtn.addEventListener('click', window.closeVideoModal);
  }

  if (videoModal) {
    videoModal.addEventListener('click', function (e) {
      if (e.target === videoModal) window.closeVideoModal();
    });
  }

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') window.closeVideoModal();
  });

  // -------------------------------------------------------------
  // 4B. Interactive Solutions Video Showcase Deck (Scroll & Tab Sync)
  // -------------------------------------------------------------
  // -------------------------------------------------------------
  // 4. Solutions Showcase with Interactive Scroll-Tied Video Scrubbing (ChainGPT Pattern)
  // -------------------------------------------------------------
  const solutionsSection = document.getElementById('solutions');
  const deckItems = Array.from(document.querySelectorAll('.solution-deck-item'));
  const deckVideo = document.getElementById('deck-live-video');
  const deckTitle = document.getElementById('deck-video-title');
  const deckDesc = document.getElementById('deck-video-desc');
  const deckTag = document.getElementById('deck-solution-tag');
  const deckLatency = document.getElementById('deck-latency-pill');
  const deckAccuracy = document.getElementById('deck-accuracy-pill');
  const scrollFill = document.getElementById('deck-scroll-scrub-fill');
  const scrollPct = document.getElementById('deck-scroll-pct');

  let activeVideoSrc = (document.documentElement.dataset.aidevVideos || 'assets/videos/') + 'solutions-scroll-video.mp4';
  let activeTitleText = '01: AI Strategy & Enterprise Feasibility';
  let targetScrubTime = 0;

  function updateSolutionDeck(item, shouldSeek = true) {
    if (!item) return;
    deckItems.forEach(i => i.classList.remove('active'));
    item.classList.add('active');

    const title = item.getAttribute('data-title') || '01: AI Strategy & Enterprise Feasibility';
    const desc = item.getAttribute('data-desc') || '';
    const tag = item.getAttribute('data-tag') || 'STRATEGY & FEASIBILITY';
    const latency = item.getAttribute('data-latency') || 'Sub-200ms';
    const accuracy = item.getAttribute('data-accuracy') || '99.8%';

    activeTitleText = title;

    if (deckTitle) deckTitle.textContent = title;
    if (deckDesc) deckDesc.textContent = desc;
    if (deckTag) deckTag.textContent = 'LIVE DEMO · ' + tag;
    if (deckLatency) deckLatency.innerHTML = '<i class="fa-solid fa-gauge-high"></i> Latency: ' + latency;
    if (deckAccuracy) deckAccuracy.innerHTML = '<i class="fa-solid fa-bullseye"></i> Accuracy: ' + accuracy;

    // If clicked or explicitly selected, seek video to that segment
    if (shouldSeek && deckVideo && deckVideo.duration && isFinite(deckVideo.duration)) {
      const idx = deckItems.indexOf(item);
      const segmentProgress = idx / Math.max(1, deckItems.length - 1);
      targetScrubTime = segmentProgress * deckVideo.duration;
      deckVideo.currentTime = targetScrubTime;
      if (scrollFill) scrollFill.style.width = (segmentProgress * 100).toFixed(1) + '%';
      if (scrollPct) scrollPct.textContent = Math.round(segmentProgress * 100) + '%';
    }
  }

  deckItems.forEach(item => {
    item.addEventListener('mouseenter', () => updateSolutionDeck(item, false));
    item.addEventListener('click', () => updateSolutionDeck(item, true));
  });

  // Real-time Scroll Scrubbing Engine (ChainGPT Video Sync)
  function onSolutionsScroll() {
    if (!solutionsSection || !deckVideo) return;
    const rect = solutionsSection.getBoundingClientRect();
    const windowH = window.innerHeight;

    if (rect.top <= windowH && rect.bottom >= 0) {
      const totalDist = rect.height - windowH * 0.5;
      const scrolledDist = windowH * 0.4 - rect.top;
      const progress = Math.max(0, Math.min(1, scrolledDist / Math.max(1, totalDist)));

      if (scrollFill) scrollFill.style.width = (progress * 100).toFixed(1) + '%';
      if (scrollPct) scrollPct.textContent = Math.round(progress * 100) + '%';

      if (deckVideo.duration && isFinite(deckVideo.duration)) {
        targetScrubTime = progress * deckVideo.duration;
        if (Math.abs(deckVideo.currentTime - targetScrubTime) > 0.04) {
          deckVideo.currentTime = targetScrubTime;
        }
      }

      // Automatically sync active solution selector card
      const targetIndex = Math.min(deckItems.length - 1, Math.floor(progress * deckItems.length));
      if (deckItems[targetIndex] && !deckItems[targetIndex].classList.contains('active')) {
        updateSolutionDeck(deckItems[targetIndex], false);
      }
    }
  }

  window.addEventListener('scroll', onSolutionsScroll, { passive: true });

  window.expandDeckVideo = function () {
    window.openVideoModal((document.documentElement.dataset.aidevVideos || 'assets/videos/') + 'solutions-scroll-video.mp4', activeTitleText);
  };


  // -------------------------------------------------------------
  // 5. Technology Matrix Category Filter
  // -------------------------------------------------------------
  const techTabs = document.querySelectorAll('.tech-tab-btn');
  const techCards = document.querySelectorAll('.tech-card');

  function applyTechFilter(filter) {
    let visibleIndex = 0;
    techCards.forEach(card => {
      const match = (filter === 'all' || card.getAttribute('data-category') === filter);
      if (match) {
        card.style.display = 'flex';
        card.classList.remove('is-visible');
        card.style.animationDelay = `${visibleIndex * 0.035}s`;
        // Trigger reflow to restart CSS animation
        void card.offsetWidth;
        card.classList.add('is-visible');
        visibleIndex++;
      } else {
        card.style.display = 'none';
        card.classList.remove('is-visible');
      }
    });
  }

  techTabs.forEach(tab => {
    tab.addEventListener('click', function () {
      techTabs.forEach(t => t.classList.remove('active'));
      this.classList.add('active');
      const filter = this.getAttribute('data-filter') || 'all';
      applyTechFilter(filter);
    });
  });

  // Initial trigger
  applyTechFilter('all');

  // -------------------------------------------------------------
  // 6. FAQ Accordion Toggle
  // -------------------------------------------------------------
  const faqItems = document.querySelectorAll('.faq-item');

  faqItems.forEach(item => {
    const header = item.querySelector('.faq-header');
    const body = item.querySelector('.faq-body');

    header.addEventListener('click', () => {
      const isActive = item.classList.contains('active');

      // Close all other items
      faqItems.forEach(other => {
        other.classList.remove('active');
        const otherBody = other.querySelector('.faq-body');
        if (otherBody) otherBody.style.maxHeight = null;
      });

      if (!isActive) {
        item.classList.add('active');
        body.style.maxHeight = body.scrollHeight + 30 + 'px';
      }
    });
  });

  // -------------------------------------------------------------
  // 7. AJAX RFP Consultation Form Submission
  // -------------------------------------------------------------
  const rfpForm = document.getElementById('ai-consultation-form');
  const formFeedback = document.getElementById('form-feedback-message');

  if (rfpForm) {
    rfpForm.addEventListener('submit', async function (e) {
      e.preventDefault();

      const submitBtn = rfpForm.querySelector('button[type="submit"]');
      const originalText = submitBtn.innerHTML;
      submitBtn.disabled = true;
      submitBtn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Processing Request...';

      const formData = new FormData(rfpForm);

      try {
        const response = await fetch('contact-handler.php', {
          method: 'POST',
          body: formData
        });

        const data = await response.json();

        if (data.status === 'success') {
          if (formFeedback) {
            formFeedback.innerHTML = `
              <div style="background: rgba(16, 185, 129, 0.15); border: 1px solid #10B981; color: #10B981; padding: 1.25rem; border-radius: 10px; margin-top: 1.25rem;">
                <strong><i class="fa-solid fa-circle-check"></i> Consultation Booked!</strong><br>
                ${data.message || 'Our AI Solution Architects will connect with you within 24 hours.'}
              </div>`;
          }
          rfpForm.reset();
          submitBtn.innerHTML = '<i class="fa-solid fa-check"></i> Request Submitted';
        } else {
          throw new Error(data.message || 'Submission failed');
        }
      } catch (err) {
        if (formFeedback) {
          formFeedback.innerHTML = `
            <div style="background: rgba(239, 68, 68, 0.15); border: 1px solid #EF4444; color: #EF4444; padding: 1.25rem; border-radius: 10px; margin-top: 1.25rem;">
              <strong><i class="fa-solid fa-circle-exclamation"></i> Error</strong><br>
              ${err.message || 'Unable to submit right now. Please email us directly at info@ithrive.ai'}
            </div>`;
        }
        submitBtn.disabled = false;
        submitBtn.innerHTML = originalText;
      }
    });
  }

  // -------------------------------------------------------------
  // 8. iThrive Floating AI Chat Assistant Widget
  // -------------------------------------------------------------
  const win = document.getElementById('tn-window');
  const launcherContainer = document.querySelector('.tn-launcher-container');
  const msgs = document.getElementById('tn-messages');
  const sugg = document.getElementById('tn-suggestions');
  const input = document.getElementById('tn-input');
  const micBtn = document.getElementById('tn-mic-btn');

  const INITIAL_SUGGESTIONS = [
    'How do you build custom LLMs?',
    'What is your typical AI project timeline & cost?',
    'Can you integrate AI into our existing ERP/CRM?',
    'Tell me about Computer Vision solutions'
  ];

  const AI_KNOWLEDGE_BASE = {
    'custom llm': "We engineer custom LLMs through domain-specific fine-tuning (LoRA / QLoRA), Retrieval-Augmented Generation (RAG) with vector databases (Pinecone/Milvus), and private on-premise or cloud deployments (vLLM/Triton) ensuring zero data leakage.",
    'timeline': "Timelines range from 4–6 weeks for an interactive MVP / Proof-of-Concept to 4–6 months for enterprise-grade generative AI pipelines and multimodal production systems. Costs in India are highly competitive compared to Western agencies.",
    'erp': "Yes! We specialize in non-invasive API microservices and secure middleware connectors for SAP, Salesforce, Microsoft Dynamics, Oracle, and custom legacy databases.",
    'vision': "We build high-accuracy Computer Vision systems using YOLO, OpenCV, and PyTorch for manufacturing defect detection, automated OCR invoice extraction, biometric authentication, and video surveillance analytics.",
    'default': "Thank you for asking! iThrive AI provides full-cycle AI development including Generative AI, LLMs, AI Agents, Computer Vision, and Enterprise Modernization across Chennai, Bangalore, Hyderabad, Coimbatore, and worldwide. Would you like to schedule an AI Architecture Discovery Call?"
  };

  window.TNChat = {
    toggle() {
      if (win.classList.contains('tn-open')) {
        this.close();
      } else {
        this.open();
      }
    },
    open() {
      win.classList.add('tn-open');
      if (launcherContainer) launcherContainer.style.display = 'none';
      if (msgs.children.length === 0) {
        _addBotMsg("Hello! 👋 Welcome to <strong>iThrive AI</strong>.<br>How can our AI Engineering team help you today? Explore LLMs, Autonomous Agents, Computer Vision, or request an RFP.");
        _renderSuggestions(INITIAL_SUGGESTIONS);
      }
      setTimeout(() => input?.focus(), 250);
    },
    close() {
      win.classList.remove('tn-open');
      if (launcherContainer) launcherContainer.style.display = 'block';
    },
    reset() {
      msgs.innerHTML = '';
      sugg.innerHTML = '';
      _addBotMsg("Chat reset! What AI capability would you like to explore? 🚀");
      _renderSuggestions(INITIAL_SUGGESTIONS);
    },
    send() {
      const text = input.value.trim();
      if (!text) return;
      input.value = '';
      sugg.innerHTML = '';
      _addUserMsg(text);
      _showTypingIndicator();

      setTimeout(() => {
        _removeTypingIndicator();
        let reply = AI_KNOWLEDGE_BASE['default'];
        const lower = text.toLowerCase();
        if (lower.includes('llm') || lower.includes('gpt') || lower.includes('rag')) {
          reply = AI_KNOWLEDGE_BASE['custom llm'];
        } else if (lower.includes('time') || lower.includes('cost') || lower.includes('price')) {
          reply = AI_KNOWLEDGE_BASE['timeline'];
        } else if (lower.includes('erp') || lower.includes('crm') || lower.includes('integrate')) {
          reply = AI_KNOWLEDGE_BASE['erp'];
        } else if (lower.includes('vision') || lower.includes('ocr') || lower.includes('image')) {
          reply = AI_KNOWLEDGE_BASE['vision'];
        }
        _addBotMsg(reply);
        _renderSuggestions([
          'Book an AI Architecture Call',
          'Explore 01-09 Solutions',
          'Download AI Tech Whitepaper'
        ]);
      }, 750);
    }
  };

  function _addBotMsg(html) {
    const row = document.createElement('div');
    row.className = 'tn-msg-row tn-bot';
    row.innerHTML = `
      <div class="tn-avatar">iT</div>
      <div class="tn-msg-bubble">${html}</div>`;
    msgs.appendChild(row);
    msgs.scrollTop = msgs.scrollHeight;
  }

  function _addUserMsg(text) {
    const row = document.createElement('div');
    row.className = 'tn-msg-row tn-user';
    row.innerHTML = `<div class="tn-msg-bubble">${text}</div>`;
    msgs.appendChild(row);
    msgs.scrollTop = msgs.scrollHeight;
  }

  function _showTypingIndicator() {
    const typing = document.createElement('div');
    typing.id = 'tn-typing-indicator';
    typing.className = 'tn-msg-row tn-bot';
    typing.innerHTML = `
      <div class="tn-avatar">iT</div>
      <div class="tn-msg-bubble" style="font-style: italic; color: var(--accent-cyan);">
        <i class="fa-solid fa-circle-notch fa-spin"></i> Analyzing AI context...
      </div>`;
    msgs.appendChild(typing);
    msgs.scrollTop = msgs.scrollHeight;
  }

  function _removeTypingIndicator() {
    document.getElementById('tn-typing-indicator')?.remove();
  }

  function _renderSuggestions(items) {
    if (!sugg) return;
    sugg.innerHTML = '';
    const wrap = document.createElement('div');
    wrap.className = 'tn-sugg-wrap';
    items.forEach(text => {
      const btn = document.createElement('button');
      btn.className = 'tn-sugg';
      btn.textContent = text;
      btn.onclick = () => {
        input.value = text;
        window.TNChat.send();
      };
      wrap.appendChild(btn);
    });
    sugg.appendChild(wrap);
  }

  // Voice recognition fallback trigger
  if (micBtn) {
    micBtn.addEventListener('click', function () {
      if (!('webkitSpeechRecognition' in window) && !('SpeechRecognition' in window)) {
        alert('Speech recognition is not supported by your browser. Please type your query.');
        return;
      }
      const SpeechRecognition = window.SpeechRecognition || window.webkitSpeechRecognition;
      const recognition = new SpeechRecognition();
      recognition.lang = 'en-US';
      recognition.start();

      micBtn.style.color = '#EF4444';
      recognition.onresult = function (event) {
        input.value = event.results[0][0].transcript;
        micBtn.style.color = '';
        window.TNChat.send();
      };
      recognition.onerror = function () {
        micBtn.style.color = '';
      };
      recognition.onend = function () {
        micBtn.style.color = '';
      };
    });
  }

  // -------------------------------------------------------------
  // 9. Section 3: Liquid Glass Optical Carousel is initialized via assets/js/liquid-glass-carousel.js
  // -------------------------------------------------------------

  // -------------------------------------------------------------
  // 10. Section 4: Framer StimulatedSlider Controller (StimulatedSlider-qikgCc)
  // -------------------------------------------------------------
  const sliderRoot = document.getElementById('stimulated-slider-root');
  const sliderTrack = document.getElementById('stimulated-slider-track');

  if (sliderRoot && sliderTrack) {
    const slides = Array.from(sliderTrack.querySelectorAll('.stimulated-slide-card'));
    const totalSlides = slides.length;
    const btnPrev = document.getElementById('slider-btn-prev');
    const btnNext = document.getElementById('slider-btn-next');
    const edgePrev = document.getElementById('slider-edge-prev');
    const edgeNext = document.getElementById('slider-edge-next');
    const pillBtns = Array.from(document.querySelectorAll('.slider-pill-btn'));

    let activeIndex = 0;
    let wheelAmount = 0;
    let lastSwipeTime = 0;

    function getSliderProps() {
      const isMobile = window.innerWidth < 768;
      return {
        activeWidth: isMobile ? 290 : 340,
        activeHeight: isMobile ? 420 : 470,
        nearWidth: isMobile ? 220 : 275,
        nearHeight: isMobile ? 360 : 410,
        farWidth: isMobile ? 170 : 220,
        farHeight: isMobile ? 300 : 350,
        sideWidth: isMobile ? 130 : 170,
        sideHeight: isMobile ? 250 : 295,
        lift: isMobile ? 6 : 14,
        gap: isMobile ? 10 : 16,
        ghostOpacity: 0.22,
        swipeSensitivity: 50,
        swipeCooldown: 380
      };
    }

    function wrapIndex(index, total) {
      return ((index % total) + total) % total;
    }

    function getSize(index, currentActive, props) {
      const distance = Math.abs(index - currentActive);
      if (distance === 0) {
        return { width: props.activeWidth, height: props.activeHeight, y: -props.lift, opacity: 1, scale: 1, zIndex: 10 };
      }
      if (distance === 1) {
        return { width: props.nearWidth, height: props.nearHeight, y: 0, opacity: 0.82, scale: 0.95, zIndex: 8 };
      }
      if (distance === 2) {
        return { width: props.farWidth, height: props.farHeight, y: 0, opacity: 0.52, scale: 0.88, zIndex: 6 };
      }
      return { width: props.sideWidth, height: props.sideHeight, y: 0, opacity: props.ghostOpacity, scale: 0.80, zIndex: 4 };
    }

    function getTrackX(slideCount, currentActive, props) {
      let center = 0;
      for (let i = 0; i < currentActive; i++) {
        center += getSize(i, currentActive, props).width + props.gap;
      }
      return -(center + getSize(currentActive, currentActive, props).width / 2);
    }

    function renderSlider(newIndex) {
      activeIndex = wrapIndex(newIndex, totalSlides);
      const props = getSliderProps();
      const trackX = getTrackX(totalSlides, activeIndex, props);

      sliderTrack.style.transform = `translateX(${trackX}px)`;

      slides.forEach((slide, i) => {
        const state = getSize(i, activeIndex, props);
        const isActive = i === activeIndex;

        slide.style.width = `${state.width}px`;
        slide.style.height = `${state.height}px`;
        slide.style.opacity = state.opacity;
        slide.style.transform = `translateY(${state.y}px) scale(${state.scale})`;
        slide.style.zIndex = state.zIndex;
        slide.classList.toggle('active', isActive);
      });

      pillBtns.forEach((pill, i) => {
        pill.classList.toggle('active', i === activeIndex);
      });
    }

    // Step Actions
    const moveBy = (amount) => renderSlider(activeIndex + amount);

    if (btnPrev) btnPrev.addEventListener('click', () => moveBy(-1));
    if (btnNext) btnNext.addEventListener('click', () => moveBy(1));
    if (edgePrev) edgePrev.addEventListener('click', () => moveBy(-1));
    if (edgeNext) edgeNext.addEventListener('click', () => moveBy(1));

    slides.forEach((slide, i) => {
      slide.addEventListener('click', () => renderSlider(i));
    });

    pillBtns.forEach((pill, i) => {
      pill.addEventListener('click', () => renderSlider(i));
    });

    // Mouse Wheel / Trackpad Gesture Swipe
    sliderRoot.addEventListener('wheel', (e) => {
      const horizontal = Math.abs(e.deltaX) > Math.abs(e.deltaY);
      const swipeDelta = horizontal ? e.deltaX : e.deltaY;
      if (Math.abs(swipeDelta) < 1) return;

      const props = getSliderProps();
      wheelAmount += swipeDelta;
      const now = Date.now();
      const canSwipe = (now - lastSwipeTime) > props.swipeCooldown;

      if (Math.abs(wheelAmount) >= props.swipeSensitivity && canSwipe) {
        moveBy(wheelAmount > 0 ? 1 : -1);
        wheelAmount = 0;
        lastSwipeTime = now;
      }
    }, { passive: true });

    // Pointer / Touch Drag Support
    let sliderDragStartX = 0;
    let sliderDragMoved = false;

    sliderRoot.addEventListener('pointerdown', (e) => {
      sliderDragStartX = e.clientX;
      sliderDragMoved = false;
    });

    sliderRoot.addEventListener('pointermove', (e) => {
      if (sliderDragStartX === 0) return;
      const dx = e.clientX - sliderDragStartX;
      if (Math.abs(dx) > 35 && !sliderDragMoved) {
        sliderDragMoved = true;
        moveBy(dx < 0 ? 1 : -1);
        sliderDragStartX = 0;
      }
    });

    const endSliderDrag = () => {
      sliderDragStartX = 0;
      sliderDragMoved = false;
    };
    sliderRoot.addEventListener('pointerup', endSliderDrag);
    sliderRoot.addEventListener('pointercancel', endSliderDrag);
    sliderRoot.addEventListener('pointerleave', endSliderDrag);

    // Keyboard Arrow Navigation when section in focus/viewport
    window.addEventListener('keydown', (e) => {
      const rect = sliderRoot.getBoundingClientRect();
      const inView = rect.top < window.innerHeight && rect.bottom > 0;
      if (!inView) return;

      if (e.key === 'ArrowLeft') {
        moveBy(-1);
      } else if (e.key === 'ArrowRight') {
        moveBy(1);
      }
    });

    // Window Resize Handler
    window.addEventListener('resize', () => renderSlider(activeIndex));

    // Initial Render
    renderSlider(0);
  }

  // -------------------------------------------------------------
  // 11. Section 5: Interactive Grid Mouse Spotlight & 3D Tilt
  // -------------------------------------------------------------
  const techGridContainer = document.getElementById('interactive-tech-grid');
  if (techGridContainer) {
    techGridContainer.addEventListener('mousemove', function (e) {
      const rect = techGridContainer.getBoundingClientRect();
      const x = e.clientX - rect.left;
      const y = e.clientY - rect.top;
      techGridContainer.style.setProperty('--mouse-x', `${x}px`);
      techGridContainer.style.setProperty('--mouse-y', `${y}px`);
    });

    const interactiveCells = techGridContainer.querySelectorAll('.interactive-cell');
    interactiveCells.forEach(cell => {
      cell.addEventListener('mousemove', function (e) {
        const rect = cell.getBoundingClientRect();
        const x = e.clientX - rect.left - rect.width / 2;
        const y = e.clientY - rect.top - rect.height / 2;
        const rotateX = (-y / (rect.height / 2)) * 12;
        const rotateY = (x / (rect.width / 2)) * 12;
        cell.style.transform = `perspective(800px) rotateX(${rotateX.toFixed(2)}deg) rotateY(${rotateY.toFixed(2)}deg) translateY(-6px) scale3d(1.04, 1.04, 1.04)`;
      });

      cell.addEventListener('mouseleave', function () {
        cell.style.transform = '';
      });
    });
  }

  // -------------------------------------------------------------
  // 12. Section 6: ArcCardCarousel is initialized via assets/js/arc-card-carousel.js
  // -------------------------------------------------------------
});

// Global prompt helpers
window.setHeroPrompt = function (text) {
  const input = document.getElementById('hero-prompt-input');
  if (input) {
    input.value = text;
    input.focus();
  }
};

window.submitHeroPrompt = function () {
  const input = document.getElementById('hero-prompt-input');
  const val = input ? input.value.trim() : '';
  if (val && window.TNChat) {
    window.TNChat.open();
    const chatInput = document.getElementById('tn-input');
    if (chatInput) {
      chatInput.value = val;
      window.TNChat.send();
    }
  } else {
    const contactSection = document.getElementById('contact');
    if (contactSection) contactSection.scrollIntoView({ behavior: 'smooth' });
  }
};

