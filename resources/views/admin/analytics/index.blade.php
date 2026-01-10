@extends('layouts.app')

@section('content')
    \u003cstyle\u003e
        /* Match admin zoom standard */
        .home-zoom {
            zoom: 0.75;
        }

        @supports not (zoom: 1) {
            .home-zoom {
                transform: scale(0.75);
                transform-origin: top center;
            }
        }
    \u003c/style\u003e

    \u003cdiv class=\"main-dashboard-inner home-zoom\"\u003e
        \u003cdiv class=\"container py-4\"\u003e
            \u003cdiv class=\"card border-0 shadow-sm\" style=\"min-height: 70vh;\"\u003e
                \u003cdiv class=\"card-body d-flex flex-column align-items-center justify-content-center text-center\"\u003e

                    \u003cdiv class=\"mb-4 p-4 rounded-circle bg-light d-flex align-items-center justify-content-center\"
                        style=\"width: 120px; height: 120px; background-color: var(--forest-green-lighter) !important;\"\u003e
                        \u003ci class=\"bi bi-bar-chart-fill\" style=\"font-size: 3.5rem; color: var(--forest-green);\"\u003e\u003c/i\u003e
                    \u003c/div\u003e

                    \u003ch2 class=\"fw-bold mb-3\" style=\"color: var(--forest-green);\"\u003eAnalytics System\u003c/h2\u003e

                    \u003cp class=\"text-muted fs-5 mb-4\" style=\"max-width: 500px;\"\u003e
                        We are currently building a powerful analytics dashboard to help you track counseling sessions and
                        student engagement.
                    \u003c/p\u003e

                    \u003cdiv class=\"badge bg-warning text-dark px-4 py-2 rounded-pill fs-6 mb-4\"\u003e
                        \u003ci class=\"bi bi-cone-striped me-2\"\u003e\u003c/i\u003eComing Soon
                    \u003c/div\u003e

                    \u003cdiv class=\"d-flex gap-3\"\u003e
                        \u003ca href=\"{{ route('dashboard') }}\" class=\"btn btn-outline-primary px-4\"\u003e
                            \u003ci class=\"bi bi-arrow-left me-2\"\u003e\u003c/i\u003eBack to Dashboard
                        \u003c/a\u003e
                    \u003c/div\u003e

                \u003c/div\u003e
            \u003c/div\u003e
        \u003c/div\u003e
    \u003c/div\u003e
@endsection