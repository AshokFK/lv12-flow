<div class="p-4">
    <!-- header detail -->
    <div class="">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2 mb-2">
            <div class="border rounded px-2 py-1">
                <div class="">Lokasi</div>
                <div class="">{{ $header->lokasi->deskripsi }}</div>
            </div>
            <div class="border rounded px-2 py-1">
                <div class="">Kontrak</div>
                <div class="">{{ $header->kontrak }}</div>
            </div>
            <div class="border rounded px-2 py-1">
                <div class="">Brand</div>
                <div class="">{{ $header->brand }}</div>
            </div>
            <div class="border rounded px-2 py-1">
                <div class="">Pattern</div>
                <div class="">{{ $header->pattern }}</div>
            </div>
            <div class="border rounded px-2 py-1">
                <div class="">Style</div>
                <div class="">{{ $header->style }}</div>
            </div>
            <div class="border rounded px-2 py-1">
                @if ($header->finished_at)
                    <div class="">Selesai</div>
                    <div class="">
                        {{ $header->finished_at->translatedFormat('j F Y') }}
                    </div>
                @else
                    <div class="">Tgl berjalan</div>
                    <div class="">
                        {{ $header->tgl_berjalan }}
                    </div>
                @endif
            </div>
            <div class="border rounded px-2 py-1">
                <div class="">Proses standar</div>
                <div class="">{{ $header->items()->where('proses_type', 'standar')->count() }}</div>
            </div>
            <div class="border rounded px-2 py-1">
                <div class="">Proses custom</div>
                <div class="">{{ $header->items()->where('proses_type', 'custom')->count() }}</div>
            </div>
        </div>
        <div class="flex justify-between gap-2 mb-2">
            <flux:button size="sm" icon="magnifying-glass-plus" id="zoomIn">Zoom In</flux:button>
            <div class="flex align-self-center">
                <input type="range" id="zoomSlider" min="10" max="300" value="100">
                <span id="zoomIndicator">Zoom: 100%</span>
            </div>
            <flux:button size="sm" icon="magnifying-glass-minus" id="zoomOut">Zoom Out</flux:button>
            <flux:button size="sm" icon="magnifying-glass" id="resetZoom">Reset Zoom</flux:button>
            <flux:button size="sm" icon="tv" id="fitScreen">Fit to Screen</flux:button>
            <flux:button size="sm" icon="arrow-uturn-left" href="{{ route('list.item', $header) }}">
                Kembali
            </flux:button>
            <flux:button size="sm" icon="inbox-arrow-down"
                x-on:click="
                const data = localStorage.getItem('appState');
                console.log('simpan posisi', data);
                $wire.savePosition(data);
                ">
                Simpan
                Posisi
            </flux:button>
        </div>
    </div>

    <!-- Kontrol Zoom -->

    <div id="wrapper" wire:ignore>
        <svg id="connections"></svg>
        @foreach ($this->items as $item)
            <div class="item" id="item-{{ $item->id }}" data-id="{{ $item->id }}"
                data-to="{{ json_encode($item->next_to) }}">
                <div class="icon">
                    <flux:icon.bolt />
                </div>
                <span @class([
                    'komponen-tim' => $item->itemable->type == 'tim',
                    'komponen-bahan' => $item->itemable->type == 'bahan',
                    'proses-qc' => $item->itemable_type == 'qc',
                    'nama-item',
                ])>{{ $item->itemable->mastercode ?? $item->itemable->nama }}</span>
            </div>
        @endforeach
        <div id="selectionBox"></div>
    </div>

    <style>
        #wrapper {
            position: relative;
            min-width: 100%;
            min-height: 500px;
            border: 2px dashed #ccc;
            overflow: auto;
            transform-origin: 0 0;
            transition: transform 0.2s ease;
        }

        #connections {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: -2;
        }

        #selectionBox {
            position: absolute;
            border: 1px dashed #007bff;
            background-color: rgba(0,123,255,0.2);
            display: none;
            pointer-events: none;
            z-index: 10;
        }

        .item {
            position: absolute;
            border: 1px solid #ccc;
            cursor: move;
            user-select: none;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: left 0.2s, top 0.2s;
        }

        .item.selected {
            background-color: rgba(179, 212, 252, 0.5);
            border: 2px solid #007bff;
        }

        .item.dragging {
            opacity: 0.5;
        }

        .item .icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 25px;
            height: 25px;
            background-color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: -1;
            padding: 2px;
        }

        .item span {
            position: absolute;
            left: 35px;
            display: block;
            white-space: nowrap;
            background: #ACC572;
            padding: 2px 5px;
            border-radius: 5px;
            border: #A76545 1px solid;
        }

        .item span::after {
            border: solid transparent;
            content: "";
            position: absolute;
            bottom: 6px;
            left: -10px;
            border-style: solid;
            border-width: 5px 10px 5px 0px;
            border-color: transparent #A76545 transparent transparent;
        }

        .komponen-tim {
            background: #FFA55D !important;
            font-weight: bold;
            text-transform: uppercase;
        }

        .komponen-bahan {
            background: #FFDF88 !important;
            text-transform: capitalize;
        }

        .proses-qc {
            background-color: #626F47 !important;
            color: #f5f5f5;
        }

        .controls {
            margin-bottom: 10px;
        }

        .controls button {
            margin-right: 5px;
            padding: 5px 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .controls button:hover {
            background-color: #0056b3;
        }

        .controls input[type="range"] {
            margin-left: 10px;
            width: 200px;
        }
    </style>

    @script
        <script>
            const wrapper = document.getElementById("wrapper");
            const svg = document.getElementById("connections");
            const zoomInBtn = document.getElementById("zoomIn");
            const zoomOutBtn = document.getElementById("zoomOut");
            const resetZoomBtn = document.getElementById("resetZoom");
            const fitScreenBtn = document.getElementById("fitScreen");
            const zoomSlider = document.getElementById("zoomSlider");
            const zoomIndicator = document.getElementById("zoomIndicator");

            let isSelecting = false;
            let startX, startY;
            const selectionBox = document.getElementById('selectionBox');

            let activeItems = [];
            let offsetPositions = [];
            let isDragging = false;
            const gridSize = 20;
            const scrollThreshold = 50;
            const scrollSpeed = 10;
            let zoomLevel = 1;
            const zoomStep = 0.1;
            const zoomMin = 0.1;
            const zoomMax = 3;
            let originalPositions = [];

            /* Snap ke grid */
            function snapToGrid(value) {
                return Math.round(value / gridSize) * gridSize;
            }

            /* Cek overlap antar item */
            function isOverlap(item, others) {
                const rect1 = item.getBoundingClientRect();
                return others.some((other) => {
                    if (item === other) return false;
                    const rect2 = other.getBoundingClientRect();
                    return !(
                        rect1.right <= rect2.left ||
                        rect1.left >= rect2.right ||
                        rect1.bottom <= rect2.top ||
                        rect1.top >= rect2.bottom
                    );
                });
            }

            /* Update ukuran wrapper */
            function updateWrapperSize() {
                let maxRight = 0,
                    maxBottom = 0;
                document.querySelectorAll(".item").forEach((item) => {
                    maxRight = Math.max(maxRight, item.offsetLeft + item.offsetWidth);
                    maxBottom = Math.max(maxBottom, item.offsetTop + item.offsetHeight);
                });
                wrapper.style.width = maxRight + 20 + "px";
                wrapper.style.height = maxBottom + 20 + "px";
            }

            /* Simpan posisi dan ukuran wrapper */
            function saveState() {
                const state = {
                    positions: [],
                    header: {
                        wrapper_width: wrapper.style.width,
                        wrapper_height: wrapper.style.height,
                        id: '{{ $header->id }}',
                    }
                };
                document.querySelectorAll(".item").forEach((item) => {
                    state.positions.push({
                        left: item.style.left,
                        top: item.style.top,
                        id: item.dataset.id
                    });
                });
                localStorage.setItem("appState", JSON.stringify(state));
            }

            /* Load posisi dan ukuran wrapper */
            function loadState() {
                const data = localStorage.getItem("appState");
                if (data) {
                    const state = JSON.parse(data);

                    if (state.header.wrapper_width) wrapper.style.width = state.header.wrapper_width;
                    if (state.header.wrapper_height) wrapper.style.height = state.header.wrapper_height;
                    state.positions.forEach((pos, index) => {
                        if (pos.id) {
                            const item = document.querySelector(`#item-${pos.id}`);
                            if (item) {
                                item.style.left = pos.left;
                                item.style.top = pos.top;
                            }
                        }
                    });
                }
            }

            function parseConnectionsFromDOM() {
                const connections = [];

                document.querySelectorAll('.item').forEach(item => {
                    const id = item.getAttribute('data-id');
                    const toRaw = item.getAttribute('data-to');

                    if (id && toRaw) {
                        try {
                            const to = JSON.parse(toRaw) ?? []; // array seperti ["2", "3"]
                            connections.push({
                                id,
                                to
                            });
                        } catch (e) {
                            console.warn(`Gagal parsing data-to dari item ${id}:`, toRaw);
                        }
                    }
                });

                return connections;
            }

            /* Draw connections */
            function drawConnections() {
                const svg = document.getElementById("connections");
                svg.innerHTML = '';

                const items = document.querySelectorAll('.item');
                const wrapperRect = wrapper.getBoundingClientRect();
                const radius = 10;

                // Map ID ➔ bounding rect
                const idMap = {};
                items.forEach(item => {
                    const id = item.getAttribute('data-id');
                    if (id) idMap[id] = item.getBoundingClientRect();
                });

                const connections = parseConnectionsFromDOM();

                connections.forEach(conn => {
                    const fromRect = idMap[conn.id];
                    if (!fromRect) return;

                    const cx1 = fromRect.left + fromRect.width / 2;
                    const cy1 = fromRect.top + fromRect.height / 2;

                    conn.to.forEach(toId => {
                        const toRect = idMap[toId];
                        if (!toRect) return;

                        const cx2 = toRect.left + toRect.width / 2;
                        const cy2 = toRect.top + toRect.height / 2;

                        const dx = cx2 - cx1;
                        const dy = cy2 - cy1;
                        const dist = Math.sqrt(dx * dx + dy * dy);
                        const ux = dx / dist;
                        const uy = dy / dist;

                        const startX = (cx1 + ux * radius - wrapperRect.left + wrapper.scrollLeft) /
                            zoomLevel;
                        const startY = (cy1 + uy * radius - wrapperRect.top + wrapper.scrollTop) /
                            zoomLevel;
                        const endX = (cx2 - wrapperRect.left + wrapper.scrollLeft) / zoomLevel;
                        const endY = (cy2 - wrapperRect.top + wrapper.scrollTop) / zoomLevel;

                        const midX = (startX + endX) / 2;
                        const midY = (startY + endY) / 2;

                        const path = document.createElementNS("http://www.w3.org/2000/svg", "path");
                        path.setAttribute("d",
                            `M${startX},${startY} L${endX},${endY}` // lurus
                            // `M${startX},${startY} L${midX},${startY} L${midX},${endY} L${endX},${endY}` siku 
                        );
                        path.setAttribute("stroke", "#007bff");
                        path.setAttribute("stroke-width", 2);
                        path.setAttribute("fill", "none");
                        svg.appendChild(path);

                        // Tambahkan marker panah di tengah jalur sesuai arah koneksi
                        const arrow = document.createElementNS("http://www.w3.org/2000/svg",
                            "path");
                        arrow.setAttribute("d",
                            "M0,0 L12,6 L0,12 L3,6 Z"
                        );
                        arrow.setAttribute("fill", "#007bff");

                        // Hitung sudut rotasi agar panah menghadap arah koneksi
                        const angle = Math.atan2(endY - startY, endX - startX) * (180 / Math.PI);
                        arrow.setAttribute("transform",
                            `translate(${midX - 12},${midY - 12}) rotate(${angle},12,12)`);
                        svg.appendChild(arrow);
                    });
                });
            }

            function updateConnections() {
                drawConnections();
            }

            /* Zoom handler */
            function applyZoom() {
                wrapper.style.transform = `scale(${zoomLevel})`;
                zoomSlider.value = Math.round(zoomLevel * 100);
                zoomIndicator.textContent = `Zoom: ${Math.round(zoomLevel * 100)}%`;
                updateConnections();
            }

            function changeZoom(delta) {
                zoomLevel = Math.max(zoomMin, Math.min(zoomMax, zoomLevel + delta));
                applyZoom();
            }

            /* Event: drag start */
            wrapper.addEventListener("mousedown", function(e) {
                if (e.target.classList.contains("item")) {
                    if (e.ctrlKey) e.target.classList.toggle("selected");
                    else {
                        document
                            .querySelectorAll(".item")
                            .forEach((i) => i.classList.remove("selected"));
                        e.target.classList.add("selected");
                    }
                    activeItems = Array.from(document.querySelectorAll(".item.selected"));
                    offsetPositions = activeItems.map((item) => ({
                        item,
                        offsetX: (e.clientX -
                                wrapper.getBoundingClientRect().left +
                                wrapper.scrollLeft) /
                            zoomLevel -
                            item.offsetLeft,
                        offsetY: (e.clientY - wrapper.getBoundingClientRect().top + wrapper
                                .scrollTop) /
                            zoomLevel -
                            item.offsetTop
                    }));
                    originalPositions = activeItems.map((item) => ({
                        item,
                        left: item.offsetLeft,
                        top: item.offsetTop
                    }));
                    isDragging = true;
                    activeItems.forEach((item) => item.classList.add("dragging"));
                } else {
                    document
                        .querySelectorAll(".item")
                        .forEach((i) => i.classList.remove("selected"));
                    activeItems = [];
                }

                if (e.target === wrapper) {
                    isSelecting = true;
                    startX = e.offsetX + wrapper.scrollLeft;
                    startY = e.offsetY + wrapper.scrollTop;
                    selectionBox.style.left = startX + 'px';
                    selectionBox.style.top = startY + 'px';
                    selectionBox.style.width = '0px';
                    selectionBox.style.height = '0px';
                    selectionBox.style.display = 'block';

                    if (!e.ctrlKey) {
                        document.querySelectorAll('.item').forEach(item => item.classList.remove('selected'));
                    }
                }
            });

            /* Event: drag move */
            wrapper.addEventListener("mousemove", function(e) {
                if (isDragging && activeItems.length) {
                    offsetPositions.forEach((pos) => {
                        let x =
                            (e.clientX -
                                wrapper.getBoundingClientRect().left +
                                wrapper.scrollLeft) /
                            zoomLevel -
                            pos.offsetX;
                        let y =
                            (e.clientY - wrapper.getBoundingClientRect().top + wrapper.scrollTop) /
                            zoomLevel -
                            pos.offsetY;
                        x = snapToGrid(x);
                        y = snapToGrid(y);
                        pos.item.style.left = x + "px";
                        pos.item.style.top = y + "px";
                    });
                    autoScroll(e);
                    updateConnections();
                }

                if (!isSelecting) return;
                const currentX = e.offsetX + wrapper.scrollLeft;
                const currentY = e.offsetY + wrapper.scrollTop;

                const x = Math.min(currentX, startX);
                const y = Math.min(currentY, startY);
                const w = Math.abs(currentX - startX);
                const h = Math.abs(currentY - startY);

                selectionBox.style.left = x + 'px';
                selectionBox.style.top = y + 'px';
                selectionBox.style.width = w + 'px';
                selectionBox.style.height = h + 'px';

                const selRect = {
                    left: x,
                    right: x + w,
                    top: y,
                    bottom: y + h
                };

                document.querySelectorAll('.item').forEach(item => {
                    const rect = {
                        left: item.offsetLeft,
                        top: item.offsetTop,
                        right: item.offsetLeft + item.offsetWidth,
                        bottom: item.offsetTop + item.offsetHeight
                    };

                    const isInside = (
                        selRect.left < rect.right &&
                        selRect.right > rect.left &&
                        selRect.top < rect.bottom &&
                        selRect.bottom > rect.top
                    );

                    if (isInside) {
                        item.classList.add('selected');
                    } else if (!e.ctrlKey) {
                        item.classList.remove('selected');
                    }
                });
            });

            /* Event: drag end */
            document.addEventListener("mouseup", function() {
                if (isDragging) {
                    const allItems = Array.from(document.querySelectorAll(".item"));
                    let hasOverlap = activeItems.some((item) => {
                        const others = allItems.filter((i) => !activeItems.includes(i));
                        return isOverlap(item, others);
                    });

                    if (hasOverlap) {
                        originalPositions.forEach((pos) => {
                            pos.item.style.left = pos.left + "px";
                            pos.item.style.top = pos.top + "px";
                        });
                        alert("Tidak boleh menimpa item lain!");
                    } else {
                        updateWrapperSize();
                        updateConnections();
                        saveState();
                    }
                }
                isDragging = false;
                activeItems.forEach((item) => item.classList.remove("dragging"));

                if (isSelecting) {
                    isSelecting = false;
                    selectionBox.style.display = 'none';
                }
            });

            document.addEventListener('keydown', (e) => {
                const selectedItems = document.querySelectorAll('.item.selected');
                if (!selectedItems.length) return;

                const step = e.shiftKey ? 10 : 1;

                let dx = 0, dy = 0;
                if (e.key === 'ArrowLeft') dx = -step;
                if (e.key === 'ArrowRight') dx = step;
                if (e.key === 'ArrowUp') dy = -step;
                if (e.key === 'ArrowDown') dy = step;

                if (dx !== 0 || dy !== 0) {
                    e.preventDefault(); // hindari scroll layar
                    selectedItems.forEach(item => {
                        const left = parseInt(item.style.left, 10) || 0;
                        const top = parseInt(item.style.top, 10) || 0;
                        item.style.left = (left + dx) + 'px';
                        item.style.top = (top + dy) + 'px';
                    });

                    // update koneksi & simpan
                    updateWrapperSize();
                    updateConnections();
                    saveState?.();
                }
            });

            /* Auto scroll saat drag mendekati tepi */
            function autoScroll(e) {
                const rect = wrapper.getBoundingClientRect();
                if (e.clientX - rect.left < scrollThreshold)
                    wrapper.scrollLeft -= scrollSpeed;
                else if (rect.right - e.clientX < scrollThreshold)
                    wrapper.scrollLeft += scrollSpeed;
                if (e.clientY - rect.top < scrollThreshold) wrapper.scrollTop -= scrollSpeed;
                else if (rect.bottom - e.clientY < scrollThreshold)
                    wrapper.scrollTop += scrollSpeed;
            }

            /* Zoom control */
            zoomInBtn.onclick = () => changeZoom(zoomStep);
            zoomOutBtn.onclick = () => changeZoom(-zoomStep);
            resetZoomBtn.onclick = () => {
                zoomLevel = 1;
                applyZoom();
            };
            fitScreenBtn.onclick = () => {
                const w = wrapper.scrollWidth,
                    h = wrapper.scrollHeight;
                const vw = window.innerWidth - 40,
                    vh = window.innerHeight - 100;
                zoomLevel = Math.min(vw / w, vh / h, 1);
                applyZoom();
            };
            zoomSlider.oninput = () => {
                zoomLevel = zoomSlider.value / 100;
                applyZoom();
            };
            wrapper.addEventListener("wheel", (e) => {
                if (e.altKey) {
                    e.preventDefault();
                    changeZoom(e.deltaY < 0 ? zoomStep : -zoomStep);
                }
            });

            /* Init */
            loadState();
            applyZoom();
            updateConnections();
        </script>
    @endscript
</div>
