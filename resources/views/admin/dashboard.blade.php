@extends('master')

@section('title', 'Dashboard Asesor')

@section('konten')
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');
        
        body {
            background-color: #f8f9fa;
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            margin: 0;
            padding: 20px 0;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px; 
        }
        
        .header-section {
            margin-bottom: 30px;
        }
        
        .header-title {
            font-size: 32px;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0 0 8px 0;
            letter-spacing: -0.5px;
        }
        
        .header-subtitle {
            font-size: 16px;
            color: #6b7280;
            margin: 0;
            font-weight: 400;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
        }
        
        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            font-size: 24px;
            color: white;
        }
        
        .icon-primary { background: #3b82f6; }
        .icon-success { background: #10b981; }
        .icon-warning { background: #f59e0b; }
        .icon-teal { background: #0d9488; }
        
        .stat-number {
            font-size: 30px;
            font-weight: 700;
            line-height: 1;
            margin: 0 0 4px 0;
            letter-spacing: -1px;
        }
        
        .stat-label {
            font-size: 16px;
            color: #6b7280;
            margin: 0 0 12px 0;
            font-weight: 500;
        }
        
        .growth-badge {
            display: inline-block;
            padding: 4px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 500;
            margin-bottom: 4px;
        }
        
        .growth-primary { background: rgba(59, 130, 246, 0.1); color: #3b82f6; }
        .growth-success { background: rgba(16, 185, 129, 0.1); color: #10b981; }
        .growth-warning { background: rgba(245, 158, 11, 0.1); color: #f59e0b; }
        .growth-teal { background: rgba(13, 148, 136, 0.1); color: #0d9488; }
        
        .growth-text {
            font-size: 12px;
            color: #9ca3af;
            margin: 0;
            font-weight: 400;
        }
        
        .chart-section {
            background: white;
            border-radius: 20px;
            padding: 32px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        .chart-title {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
            margin: 0 0 24px 0;
            letter-spacing: -0.3px;
        }
        
        .chart-container {
            position: relative;
            height: 300px;
            margin-bottom: 24px;
        }
        
        .chart-stats {
            display: flex;
            justify-content: space-between;
            padding-top: 20px;
            border-top: 1px solid #f3f4f6;
            font-size: 14px;
        }
        
        .chart-stat-item {
            text-align: center;
            flex: 1;
        }
        
        .chart-stat-number {
            font-weight: 700;
            font-size: 16px;
        }
        
        .chart-stat-label {
            color: #6b7280;
            margin-top: 2px;
            font-weight: 400;
        }
        
        .text-primary { color: #3b82f6; }
        .text-success { color: #10b981; }
        .text-warning { color: #f59e0b; }
        
        @media (max-width: 768px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }
            .stat-card {
                padding: 20px;
            }
            .chart-section {
                padding: 24px 20px;
            }
        }
        
        @media (max-width: 480px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header-section">
            <p class="header-title">Dashboard Admin</p>
            <p class="header-subtitle">Kelola asesmen dengan standar profesional terdepan</p>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <!-- Total Peserta -->
            <div class="stat-card">
                <div class="stat-icon icon-primary">
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div class="stat-number text-primary">284</div>
                <div class="stat-label">Total Peserta</div>
                <div class="growth-badge growth-primary">12.5% Growth</div>
                <div class="growth-text">This Month</div>
            </div>

            <!-- Sertifikat -->
            <div class="stat-card">
                <div class="stat-icon icon-success">
                    <i class="fas fa-layer-group"></i>
                </div>
                <div class="stat-number text-success">284</div>
                <div class="stat-label">Sertifikat</div>
                <div class="growth-badge growth-success">12.5% Growth</div>
                <div class="growth-text">This Month</div>
            </div>

            <!-- Dalam Progres -->
            <div class="stat-card">
                <div class="stat-icon icon-warning">
                    <i class="fas fa-chart-line"></i>
                </div>
                <div class="stat-number text-warning">284</div>
                <div class="stat-label">Dalam Progres</div>
                <div class="growth-badge growth-warning">12.5% Growth</div>
                <div class="growth-text">This Month</div>
            </div>

            <!-- Penghargaan -->
            <div class="stat-card">
                <div class="stat-icon icon-teal">
                    <i class="fas fa-list-check"></i>
                </div>
                <div class="stat-number" style="color: #0d9488;">284</div>
                <div class="stat-label">Penghargaan</div>
                <div class="growth-badge growth-teal">12.5% Growth</div>
                <div class="growth-text">This Month</div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="chart-section">
            <h2 class="chart-title">Grafik Sertifikasi</h2>
            <div class="chart-container">
                <canvas id="barChart"></canvas>
            </div>
            
            <div class="chart-stats">
                <div class="chart-stat-item">
                    <div class="chart-stat-number text-primary">300</div>
                    <div class="chart-stat-label">Total Tersertifikasi</div>
                </div>
                <div class="chart-stat-item">
                    <div class="chart-stat-number text-success">18%</div>
                    <div class="chart-stat-label">Rata-rata Pertumbuhan</div>
                </div>
                <div class="chart-stat-item">
                    <div class="chart-stat-number text-warning">MPLB</div>
                    <div class="chart-stat-label">Jurusan Terbanyak Sertifikasi</div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('barChart').getContext('2d');
            
            // Create gradient for bars
            const createGradient = (ctx, color1, color2) => {
                const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                gradient.addColorStop(0, color1);
                gradient.addColorStop(1, color2);
                return gradient;
            };
            
            const chart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['akl', 'mplb', 'pemasaran', 'm-log', 'dkv', 'rpl', 'tjkt'],
                    datasets: [{
                        data: [45, 65, 30, 15, 40, 50, 15],
                        backgroundColor: [
                            createGradient(ctx, '#f59e0b', '#f7d16fff'), // akl - yellow gradient
                            createGradient(ctx, '#3b82f6', '#bdcff2ff'), // mplb - blue gradient  
                            createGradient(ctx, '#ef4444', '#ff8b8bff'), // pemasaran - red gradient
                            createGradient(ctx, '#f97316', '#f4aa75ff'), // m-log - orange gradient
                            createGradient(ctx, '#940BE8', '#d7b2f7ff'), // dkv - purple gradient
                            createGradient(ctx, '#13d159ff', '#6bfaa0ff'), // rpl - green gradient
                            createGradient(ctx, '#545555ff', '#909090ff')  // tjkt - gray gradient
                        ],
                        borderRadius: 8,
                        borderSkipped: false,
                        barThickness: 60
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { 
                            display: false 
                        },
                        tooltip: {
                            enabled: true,
                            backgroundColor: '#1f2937',
                            titleColor: '#ffffff',
                            bodyColor: '#ffffff',
                            borderColor: '#374151',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: false,
                            callbacks: {
                                title: function(context) {
                                    return context[0].label.toUpperCase();
                                },
                                label: function(context) {
                                    return context.parsed.y + ' siswa tersertifikasi';
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            grid: { 
                                color: '#f3f4f6',
                                drawBorder: false
                            },
                            ticks: {
                                stepSize: 20,
                                callback: function(value) { 
                                    return value + ' peserta'; 
                                },
                                color: '#9ca3af',
                                font: {
                                    size: 12,
                                    family: 'Inter'
                                }
                            }
                        },
                        x: {
                            grid: { 
                                display: false 
                            },
                            ticks: {
                                color: '#6b7280',
                                font: {
                                    size: 12,
                                    family: 'Inter'
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    onHover: (event, elements) => {
                        event.native.target.style.cursor = elements.length > 0 ? 'pointer' : 'default';
                    }
                }
            });

            // Add tooltip for MPLB bar (highest)
            const addTooltip = () => {
                const mplbBar = chart.getDatasetMeta(0).data[1];
                if (mplbBar) {
                    const tooltip = document.createElement('div');
                    tooltip.innerHTML = `
                        <div style="
                            position: absolute;
                            background: #1f2937;
                            color: white;
                            padding: 8px 12px;
                            border-radius: 6px;
                            font-size: 12px;
                            font-weight: 500;
                            top: ${mplbBar.y - 40}px;
                            left: ${mplbBar.x - 30}px;
                            transform: translateX(-50%);
                            pointer-events: none;
                            z-index: 1000;
                        ">
                            MPLB<br>
                            <span style="font-size: 10px; opacity: 0.8;">65 siswa tersertifikasi</span>
                        </div>
                    `;
                    chart.canvas.parentNode.appendChild(tooltip.firstElementChild);
                }
            };

           
        });
    </script>
</body>
</html>
@endsection

