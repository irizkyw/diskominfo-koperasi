<div id="kt_activities" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="activities"
    data-kt-drawer-activate="true" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'500px', 'lg': '500px'}"
    data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_activities_toggle"
    data-kt-drawer-close="#kt_activities_close" style="width: 500px;"> <!-- Set a fixed width -->

    <div class="card shadow-none border-0 rounded-0" style="width: 100%;"> <!-- Ensure card takes full width -->
        <!--begin::Header-->
        <div class="card-header py-5" id="kt_activities_header" style="width: 100%;"> <!-- Ensure header spans full width -->
            <h3 class="card-title fw-bold text-gray-900">ACARA</h3>
            <div class="card-toolbar">
                <button type="button" class="btn btn-sm btn-icon btn-active-light-primary me-n5"
                    id="kt_activities_close">
                    <i class="ki-outline ki-cross fs-1"></i>
                </button>
            </div>
        </div>
        <!--end::Header-->
        <!--begin::Body-->
        <div class="card-body position-relative" id="kt_activities_body">
            <!--begin::Content-->
            <div id="kt_activities_scroll" class="position-relative scroll-y me-n5 pe-5" data-kt-scroll="true"
                data-kt-scroll-height="auto" data-kt-scroll-wrappers="#kt_activities_body"
                data-kt-scroll-dependencies="#kt_activities_header, #kt_activities_footer"
                data-kt-scroll-offset="5px">
                <!--begin::Timeline items-->
                <div class="timeline timeline-border-dashed">
                    <!--begin::Timeline item-->
                    <!-- Add your timeline items here -->
                    <!--end::Timeline item-->
                </div>
                <!--end::Timeline items-->
            </div>
            <!--end::Content-->
        </div>
        <!--end::Body-->
    </div>
</div>


<!-- DO NOT TOUCH CROSS THIS LINE. I REPEAT, DO NOT CROSS THIS LINE -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#kt_activities_toggle').on('click', function() {
            $.ajax({
                url: '{{ route("event.data") }}',
                type: 'GET',
                success: function(data) {
                    var timelineContainer = $('.timeline');
                    timelineContainer.empty();

                    data.sort(function(a, b) {
                        return new Date(a.tanggal_event) - new Date(b.tanggal_event);
                    });

                    data.forEach(function(event) {
                        var timelineItem = `
                            <div class="timeline-item">
                                <div class="timeline-line"></div>
                                <div class="timeline-icon">
                                    <i class="ki-outline ki-notification-on fs-2"></i>
                                </div>
                                <div class="timeline-content mb-10 mt-n1">
                                    <div class="pe-3 mb-5">
                                        <div class="fs-5 fw-semibold mb-2 text-gray-900">${event.nama_event}</div>
                                        <div class="d-flex align-items-center mt-1 fs-6">
                                            <div class="text-muted me-2 fs-7 text-white">${event.deskripsi_event}</div>
                                        </div>
                                        <div class="d-flex align-items-center mt-1 fs-6">
                                            <div class="text-muted me-2 fs-7 text-white">Dilaksanakan pada ${new Date(event.tanggal_event).toLocaleDateString()}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>`;
                        timelineContainer.append(timelineItem);
                    });
                }
            });
        });
    });
</script>
