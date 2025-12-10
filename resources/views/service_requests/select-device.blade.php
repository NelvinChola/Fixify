@extends('layouts.admin')

@section('content')
    <div class="container py-4">
        {{-- Page Header --}}
        <div class="text-center mb-5">
            <h1 class="display-6 fw-bold text-gradient-primary mb-3">Select Your Device</h1>
            <p class="text-muted lead">Choose the device you've brought in for repair to proceed with service request</p>
            {{-- <div class="progress-container mx-auto" style="max-width: 300px;">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-primary fw-semibold small">1. Select Device</span>
                    <span class="text-muted small">2. Describe Issues</span>
                    <span class="text-muted small">3. Confirm</span>
                </div>
                <div class="progress" style="height: 4px;">
                    <div class="progress-bar bg-primary" style="width: 33%"></div>
                </div>
            </div> --}}
        </div>

        @if ($devices->isEmpty())
            {{-- Empty State --}}
            <div class="empty-state text-center py-5">
                <div class="empty-state-icon mb-4">
                    <i class="fas fa-mobile-alt fa-4x text-light"></i>
                </div>
                <h3 class="fw-bold mb-3">No Devices Available</h3>
                <p class="text-muted mb-4">Currently there are no devices in the system. Please contact support if this
                    seems incorrect.</p>
                <a href="{{ url()->previous() }}" class="btn btn-outline-primary">
                    <i class="fas fa-arrow-left me-2"></i>Go Back
                </a>
            </div>
        @else
            {{-- Device Grid --}}
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                @foreach ($devices as $device)
                    <div class="col">
                        <div class="card device-card h-100 border-0">
                            {{-- Device Image with Status --}}
                            <div class="card-img-container position-relative">
                                <div class="device-image-wrapper">
                                    @if ($device->image)
                                        <img src="{{ Storage::url($device->image) }}" class="device-image"
                                            alt="{{ $device->name }}" loading="lazy"
                                            onerror="this.src='https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80'">
                                    @else
                                        <img src="https://images.unsplash.com/photo-1511707171634-5f897ff02aa9?ixlib=rb-4.0.3&auto=format&fit=crop&w=500&q=80"
                                            class="device-image" alt="Device Image" loading="lazy">
                                    @endif

                                    {{-- Category Badge --}}
                                    <div class="category-badge">
                                        <span class="badge bg-white text-dark shadow-sm">
                                            <i class="fas fa-tag me-1"></i>{{ $device->category->name ?? 'General' }}
                                        </span>
                                    </div>
                                </div>

                                {{-- Quick Info Overlay --}}
                                <div class="quick-info-overlay">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <h6 class="mb-0 fw-bold text-white">{{ Str::limit($device->name, 18) }}</h6>
                                            <div class="device-specs text-white-50">
                                                <small>
                                                    {{ $device->brand ?? 'Brand' }} | {{ $device->model ?? 'Model' }}
                                                </small>
                                            </div>
                                        </div>
                                        <span class="device-type-icon">
                                            @if (str_contains(strtolower($device->name), 'phone') ||
                                                    str_contains(strtolower($device->category->name ?? ''), 'phone'))
                                                <i class="fas fa-mobile-alt"></i>
                                            @elseif(str_contains(strtolower($device->name), 'laptop') ||
                                                    str_contains(strtolower($device->category->name ?? ''), 'laptop'))
                                                <i class="fas fa-laptop"></i>
                                            @elseif(str_contains(strtolower($device->name), 'tablet') ||
                                                    str_contains(strtolower($device->category->name ?? ''), 'tablet'))
                                                <i class="fas fa-tablet-alt"></i>
                                            @else
                                                <i class="fas fa-device"></i>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Card Body --}}
                            <div class="card-body d-flex flex-column p-3">
                                {{-- Device Details --}}
                                <div class="device-details mb-3 flex-grow-1">
                                    <div class="detail-item mb-2">
                                        <span class="detail-label text-muted small">Brand</span>
                                        <span
                                            class="detail-value fw-semibold">{{ $device->brand ?? 'Not specified' }}</span>
                                    </div>
                                    <div class="detail-item mb-2">
                                        <span class="detail-label text-muted small">Model</span>
                                        <span
                                            class="detail-value fw-semibold">{{ $device->model ?? 'Not specified' }}</span>
                                    </div>
                                    @if ($device->serial_number)
                                        <div class="detail-item">
                                            <span class="detail-label text-muted small">Serial</span>
                                            <span
                                                class="detail-value text-truncate d-block">{{ $device->serial_number }}</span>
                                        </div>
                                    @endif
                                </div>

                                {{-- Action Button --}}
                                <a href="{{ route('service-requests.select-issues', $device->id) }}"
                                    class="btn btn-primary btn-select-device mt-auto shadow-sm">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <span>Select This Device</span>
                                    <i class="fas fa-arrow-right ms-1 small"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Help Text --}}
            <div class="text-center mt-5 pt-4 border-top">
                <p class="text-muted small">
                    <i class="fas fa-info-circle me-1"></i>
                    Can't find your device?
                    <a href="#" class="text-decoration-none" data-bs-toggle="modal" data-bs-target="#helpModal">
                        Contact support for assistance
                    </a>
                </p>
            </div>
        @endif
    </div>

    {{-- Help Modal --}}
    <div class="modal fade" id="helpModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Need Help?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>If your device isn't listed, it may need to be registered first. Please:</p>
                    <ol>
                        <li>Contact our support team at <strong>nelzeeakanyc@gmail.com</strong></li>
                        <li>Provide your device details and receipt</li>
                        <li>We'll add your device within 24 hours</li>
                    </ol>
                    <p class="mb-0">Or visit our service desk for immediate assistance.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                    <a href="mailto:nelzeeakanyc@gmail.com" class="btn btn-primary">
                        <i class="fas fa-envelope me-1"></i>Email Support
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --primary-color: #1e3a8a;
            --primary-hover: #2563eb;
            --card-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --card-shadow-hover: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --card-shadow-hover-primary: 0 20px 25px -5px rgba(30, 58, 138, 0.1), 0 10px 10px -5px rgba(30, 58, 138, 0.04);
            --card-border: 1px solid #e5e7eb;
        }

        .text-gradient-primary {
            background: linear-gradient(135deg, var(--primary-color), #3b82f6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .device-card {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 12px;
            overflow: hidden;
            background: white;
            border: var(--card-border);
            box-shadow: var(--card-shadow);
            position: relative;
        }

        .device-card:hover {
            transform: translateY(-8px);
            box-shadow: var(--card-shadow-hover-primary);
            border-color: #d1d5db;
        }

        /* Subtle shadow animation on hover */
        .device-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            border-radius: 12px;
            box-shadow: 0 25px 50px -12px rgba(30, 58, 138, 0.25);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
        }

        .device-card:hover::after {
            opacity: 1;
        }

        .card-img-container {
            height: 180px;
            position: relative;
            background: linear-gradient(135deg, #f8fafc, #f1f5f9);
        }

        .device-image-wrapper {
            height: 100%;
            width: 100%;
            overflow: hidden;
        }

        .device-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .device-card:hover .device-image {
            transform: scale(1.05);
        }

        .quick-info-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0, 0, 0, 0.8));
            padding: 16px;
            color: white;
        }

        .category-badge {
            position: absolute;
            top: 12px;
            right: 12px;
        }

        .category-badge .badge {
            backdrop-filter: blur(4px);
            font-weight: 500;
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 20px;
        }

        .device-type-icon {
            font-size: 1.2rem;
            color: rgba(255, 255, 255, 0.9);
        }

        .detail-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .detail-label {
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #6b7280;
        }

        .detail-value {
            font-size: 0.875rem;
            color: #1f2937;
            font-weight: 500;
        }

        .btn-select-device {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-hover));
            border: none;
            border-radius: 8px;
            padding: 10px 16px;
            font-weight: 600;
            letter-spacing: 0.3px;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(30, 58, 138, 0.2);
        }

        .btn-select-device:hover {
            background: linear-gradient(135deg, var(--primary-hover), var(--primary-color));
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.3);
        }

        .empty-state {
            background: white;
            border-radius: 16px;
            max-width: 500px;
            margin: 0 auto;
            box-shadow: var(--card-shadow);
            border: var(--card-border);
        }

        .empty-state-icon {
            opacity: 0.7;
        }

        @media (max-width: 768px) {
            .card-img-container {
                height: 160px;
            }

            .device-card:hover {
                transform: translateY(-4px);
            }

            .device-card::after {
                box-shadow: 0 15px 30px -8px rgba(30, 58, 138, 0.2);
            }

            .display-6 {
                font-size: 1.8rem;
            }
        }

        /* Loading state animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .device-card {
            animation: fadeInUp 0.4s ease forwards;
            animation-delay: calc(var(--card-index) * 0.1s);
            opacity: 0;
        }

        /* Card stacking effect for better visual hierarchy */
        .row.g-4>.col:nth-child(odd) .device-card {
            transform: perspective(1000px) rotateY(1deg);
        }

        .row.g-4>.col:nth-child(even) .device-card {
            transform: perspective(1000px) rotateY(-1deg);
        }

        .row.g-4>.col .device-card:hover {
            transform: translateY(-8px) perspective(1000px) rotateY(0deg);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Add animation delays to cards
            const cards = document.querySelectorAll('.device-card');
            cards.forEach((card, index) => {
                card.style.setProperty('--card-index', index);
            });

            // Add subtle hover effect for touch devices
            cards.forEach(card => {
                card.addEventListener('touchstart', function() {
                    this.style.boxShadow = 'var(--card-shadow-hover-primary)';
                    this.style.transform = 'translateY(-4px)';
                });

                card.addEventListener('touchend', function() {
                    setTimeout(() => {
                        this.style.boxShadow = 'var(--card-shadow)';
                        this.style.transform = 'translateY(0)';
                    }, 150);
                });
            });
        });
    </script>
@endsection
