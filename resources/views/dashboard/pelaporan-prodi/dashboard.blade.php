<x-dashboard-layout title="Dashboard">
    <x-slot name="header">
        Dashboard
    </x-slot>

    <div class="card px-4 pt-4 pb-3 mb-4">
        <div class="row">
            <div class="col-md-6">
                <h3>Statistik Verifikasi</h3>
                <div id="chart-verification-status"></div>
            </div>
            <div class="mt-4 col-md-6">
                <h3>Nilai Rata-rata</h3>
                <div id="chart-average-scores"></div>
            </div>
        </div>
    </div>

    <script>
        var verificationStatusOptions = {
            chart: {
                type: 'pie'
            },
            series: [
                {{ $verificationStatus->where('status_verifikasi', 'approved')->sum('total') }},
                {{ $verificationStatus->where('status_verifikasi', 'pending')->sum('total') }},
                {{ $verificationStatus->where('status_verifikasi', 'draft')->sum('total') }},
            ],
            labels: ['Disetujui', 'Menunggu Persetujuan', 'Draft'],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: {
                        width: 200
                    },
                    legend: {
                        position: 'bottom'
                    }
                }
            }]
        };

        var verificationStatusChart = new ApexCharts(document.querySelector("#chart-verification-status"),
            verificationStatusOptions);
        verificationStatusChart.render();

        var averageScoresOptions = {
            chart: {
                type: 'bar'
            },
            series: [{
                data: [
                    {{ $averageScores->avg_case_method }},
                    {{ $averageScores->avg_project_based }},
                    {{ $averageScores->avg_cognitive_task }},
                    {{ $averageScores->avg_cognitive_quiz }},
                    {{ $averageScores->avg_cognitive_uts }},
                    {{ $averageScores->avg_cognitive_uas }}
                ]
            }],
            xaxis: {
                categories: ['Case Method', 'Project Based', 'Cognitive Task', 'Cognitive Quiz', 'Cognitive UTS',
                    'Cognitive UAS'
                ]
            }
        };

        var averageScoresChart = new ApexCharts(document.querySelector("#chart-average-scores"), averageScoresOptions);
        averageScoresChart.render();
    </script>
</x-dashboard-layout>
