<div class="w-full bg-gray-100 px-2 py-6 md:px-6">
    <style>
        @keyframes catalogSpin {
            to { transform: rotate(360deg); }
        }
        .catalog-spinner {
            width: 26px;
            height: 26px;
            border: 3px solid #e5e7eb;
            border-top-color: #dc2626;
            border-radius: 9999px;
            animation: catalogSpin .8s linear infinite;
        }
        .catalog-loading.hidden {
            display: none;
        }
        .catalog-header p {
            margin-bottom: 0 !important;
        }
    </style>

    <header class="catalog-header mx-auto mb-6 max-w-screen-2xl rounded-xl border border-gray-200 bg-white p-4 md:p-5">
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
            <div class="min-w-0">
                <h1 class="text-2xl font-semibold text-gray-900">{{ __('Rubyshop Catalog') }}</h1>
                <p class="mt-1 text-sm text-gray-500">{{ __('Sectioned viewer - page') }} {{ $page }}</p>
            </div>

            <div class="flex w-full flex-wrap items-center gap-2 lg:w-auto lg:justify-end">
                @if ($prevPageUrl)
                    <a href="{{ $prevPageUrl }}" class="whitespace-nowrap rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:border-red-500 hover:text-red-500">
                        {{ __('Previous') }}
                    </a>
                @endif

                <a href="{{ $nextPageUrl }}" class="whitespace-nowrap rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:border-red-500 hover:text-red-500">
                    {{ __('Next') }}
                </a>

                <a href="{{ route('catalog.file') }}" target="_blank" rel="noopener noreferrer" class="whitespace-nowrap rounded-md border border-gray-300 px-4 py-2 text-sm text-gray-700 hover:border-red-500 hover:text-red-500">
                    {{ __('Open PDF') }}
                </a>
            </div>
        </div>
    </header>

    <div class="mx-auto max-w-screen-2xl">
        <div id="catalog-loading" class="catalog-loading mb-4 flex items-center gap-3 rounded-lg border border-gray-200 bg-white p-3 text-sm text-gray-700">
            <span class="catalog-spinner" aria-hidden="true"></span>
            <span id="catalog-status">{{ __('Loading catalog...') }}</span>
        </div>
        <div id="catalog-pages" class="flex flex-col gap-8"></div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.min.js" defer></script>
<script>
    document.addEventListener('DOMContentLoaded', async function () {
        const statusEl = document.getElementById('catalog-status');
        const loadingEl = document.getElementById('catalog-loading');
        const container = document.getElementById('catalog-pages');
        const pdfUrl = @json(route('catalog.file'));
        const initialPage = {{ max(1, (int) $page) }};
        const debugHeaderPattern = /(HTTP\/1\.0 200 OK|Activated-License:\s*[^\n]+|Authorization-At:\s*[^\n]+|Cache-Control:\s*[^\n]+|Cms-Version:\s*[^\n]+|Date:\s*[^\n]+)/gi;

        function sanitizeDebugText(message) {
            if (! message) {
                return '';
            }

            return String(message).replace(debugHeaderPattern, '').replace(/\s{2,}/g, ' ').trim();
        }

        function setStatus(message) {
            if (statusEl) {
                statusEl.textContent = sanitizeDebugText(message) || 'Loading catalog...';
            }
        }

        function setLoading(isLoading) {
            if (! loadingEl) {
                return;
            }

            loadingEl.classList.toggle('hidden', !isLoading);
        }

        function scrubDebugHeaderText(node) {
            if (! node) {
                return;
            }

            if (node.nodeType === Node.TEXT_NODE) {
                const sanitized = sanitizeDebugText(node.textContent);
                if (sanitized !== node.textContent) {
                    node.textContent = sanitized;
                }
                return;
            }

            node.childNodes.forEach(function (child) {
                scrubDebugHeaderText(child);
            });
        }

        scrubDebugHeaderText(document.body);

        const textObserver = new MutationObserver(function (mutations) {
            mutations.forEach(function (mutation) {
                mutation.addedNodes.forEach(function (addedNode) {
                    scrubDebugHeaderText(addedNode);
                });
            });
        });

        textObserver.observe(document.body, { childList: true, subtree: true });

        setLoading(true);
        setStatus('Loading catalog...');

        if (! container || ! window.pdfjsLib) {
            setStatus('Unable to initialize catalog renderer.');
            setLoading(false);
            return;
        }

        window.pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.16.105/pdf.worker.min.js';

        try {
            const pdf = await window.pdfjsLib.getDocument(pdfUrl).promise;
            const renderedPages = new Set();

            for (let pageNumber = 1; pageNumber <= pdf.numPages; pageNumber++) {
                const sectionId = 'catalog-page-' + pageNumber;

                const section = document.createElement('section');
                section.id = sectionId;
                section.className = 'catalog-page scroll-mt-28 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm';
                section.dataset.page = String(pageNumber);
                section.innerHTML = '' +
                    '<div class="border-b border-gray-200 px-4 py-2 text-sm font-medium text-gray-600">Section ' + pageNumber + '</div>' +
                    '<div class="p-2 md:p-4">' +
                        '<canvas class="catalog-canvas mx-auto block h-auto w-full"></canvas>' +
                    '</div>';

                container.appendChild(section);
            }

            async function renderPage(section) {
                const pageNumber = Number(section.dataset.page);

                if (! pageNumber || renderedPages.has(pageNumber)) {
                    return;
                }

                renderedPages.add(pageNumber);

                const page = await pdf.getPage(pageNumber);
                const canvas = section.querySelector('canvas');

                if (! canvas) {
                    return;
                }

                const context = canvas.getContext('2d');
                const cssWidth = Math.max(320, section.clientWidth - 32);
                const baseViewport = page.getViewport({ scale: 1 });
                const cssScale = cssWidth / baseViewport.width;
                const viewport = page.getViewport({ scale: cssScale });
                const pixelRatio = window.devicePixelRatio || 1;

                canvas.width = Math.floor(viewport.width * pixelRatio);
                canvas.height = Math.floor(viewport.height * pixelRatio);
                canvas.style.width = Math.floor(viewport.width) + 'px';
                canvas.style.height = Math.floor(viewport.height) + 'px';
                context.setTransform(pixelRatio, 0, 0, pixelRatio, 0, 0);

                await page.render({
                    canvasContext: context,
                    viewport,
                }).promise;
            }

            const observer = new IntersectionObserver(function (entries) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        renderPage(entry.target);
                    }
                });
            }, { rootMargin: '600px 0px' });

            container.querySelectorAll('.catalog-page').forEach(function (section) {
                observer.observe(section);
            });

            const initialSection = container.querySelector('[data-page="' + initialPage + '"]');
            if (initialSection) {
                await renderPage(initialSection);
                initialSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }

            setStatus('Loaded ' + pdf.numPages + ' pages.');
            setLoading(false);
        } catch (error) {
            console.error(error);
            setStatus('Failed to load catalog. Please use "Open PDF" button.');
            setLoading(false);
        }
    });
</script>
