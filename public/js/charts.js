// Charts and Analytics functionality
class ChartsManager {
    constructor() {
        this.charts = {};
        this.init();
    }

    init() {
        // Initialize charts when analytics section is first opened
        this.createMoodTrendChart();
        this.createNutritionChart();
        this.createMoodDistributionChart();
        this.createWeeklyProgressChart();
    }

    getMoodHistory() {
        return JSON.parse(localStorage.getItem('moodHistory') || '[]');
    }

    createMoodTrendChart() {
        const ctx = document.getElementById('moodTrendChart');
        if (!ctx) return;

        const moodHistory = this.getMoodHistory();
        const last7Days = this.getLast7DaysData(moodHistory);

        const data = {
            labels: last7Days.labels,
            datasets: [{
                label: 'Mood Intensity',
                data: last7Days.intensities,
                borderColor: 'rgb(102, 126, 234)',
                backgroundColor: 'rgba(102, 126, 234, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgb(102, 126, 234)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 6
            }]
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Tren Mood 7 Hari Terakhir',
                        font: { size: 16, weight: 'bold' }
                    },
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 10,
                        ticks: {
                            stepSize: 1,
                            callback: function(value) {
                                return value + '/10';
                            }
                        },
                        title: {
                            display: true,
                            text: 'Intensitas Mood'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Hari'
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart'
                }
            }
        };

        if (this.charts.moodTrend) {
            this.charts.moodTrend.destroy();
        }
        this.charts.moodTrend = new Chart(ctx, config);
    }

    createNutritionChart() {
        const ctx = document.getElementById('nutritionChart');
        if (!ctx) return;

        // Mock nutrition data based on mood history
        const nutritionData = this.calculateNutritionData();

        const data = {
            labels: ['Protein', 'Karbohidrat', 'Lemak', 'Serat', 'Vitamin'],
            datasets: [{
                label: 'Intake Harian (g)',
                data: nutritionData,
                backgroundColor: [
                    'rgba(72, 187, 120, 0.8)',
                    'rgba(102, 126, 234, 0.8)',
                    'rgba(237, 137, 54, 0.8)',
                    'rgba(118, 75, 162, 0.8)',
                    'rgba(245, 101, 101, 0.8)'
                ],
                borderColor: [
                    'rgb(72, 187, 120)',
                    'rgb(102, 126, 234)',
                    'rgb(237, 137, 54)',
                    'rgb(118, 75, 162)',
                    'rgb(245, 101, 101)'
                ],
                borderWidth: 2
            }]
        };

        const config = {
            type: 'doughnut',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Distribusi Nutrisi Harian',
                        font: { size: 16, weight: 'bold' }
                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    duration: 2000
                }
            }
        };

        if (this.charts.nutrition) {
            this.charts.nutrition.destroy();
        }
        this.charts.nutrition = new Chart(ctx, config);
    }

    createMoodDistributionChart() {
        const ctx = document.getElementById('moodDistributionChart');
        if (!ctx) return;

        const moodHistory = this.getMoodHistory();
        const moodCounts = this.calculateMoodDistribution(moodHistory);

        const moodColors = {
            sedih: 'rgba(245, 101, 101, 0.8)',
            senang: 'rgba(72, 187, 120, 0.8)',
            marah: 'rgba(237, 137, 54, 0.8)',
            cemas: 'rgba(118, 75, 162, 0.8)',
            stress: 'rgba(66, 153, 225, 0.8)',
            lelah: 'rgba(128, 128, 128, 0.8)'
        };

        const data = {
            labels: Object.keys(moodCounts).map(mood => 
                mood.charAt(0).toUpperCase() + mood.slice(1)
            ),
            datasets: [{
                data: Object.values(moodCounts),
                backgroundColor: Object.keys(moodCounts).map(mood => moodColors[mood]),
                borderColor: Object.keys(moodCounts).map(mood => 
                    moodColors[mood].replace('0.8', '1')
                ),
                borderWidth: 2
            }]
        };

        const config = {
            type: 'pie',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Distribusi Mood',
                        font: { size: 16, weight: 'bold' }
                    },
                    legend: {
                        position: 'right',
                        labels: {
                            padding: 15,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return `${context.label}: ${context.parsed} (${percentage}%)`;
                            }
                        }
                    }
                },
                animation: {
                    animateRotate: true,
                    duration: 2000
                }
            }
        };

        if (this.charts.moodDistribution) {
            this.charts.moodDistribution.destroy();
        }
        this.charts.moodDistribution = new Chart(ctx, config);
    }

    createWeeklyProgressChart() {
        const ctx = document.getElementById('weeklyProgressChart');
        if (!ctx) return;

        const weeklyData = this.getWeeklyProgressData();

        const data = {
            labels: ['Ming 1', 'Ming 2', 'Ming 3', 'Ming 4'],
            datasets: [
                {
                    label: 'Rata-rata Mood',
                    data: weeklyData.avgMood,
                    borderColor: 'rgb(102, 126, 234)',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    yAxisID: 'y'
                },
                {
                    label: 'Jumlah Entri',
                    data: weeklyData.entryCount,
                    borderColor: 'rgb(72, 187, 120)',
                    backgroundColor: 'rgba(72, 187, 120, 0.1)',
                    yAxisID: 'y1'
                }
            ]
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: {
                    mode: 'index',
                    intersect: false
                },
                plugins: {
                    title: {
                        display: true,
                        text: 'Progress Mingguan',
                        font: { size: 16, weight: 'bold' }
                    }
                },
                scales: {
                    x: {
                        display: true,
                        title: {
                            display: true,
                            text: 'Minggu'
                        }
                    },
                    y: {
                        type: 'linear',
                        display: true,
                        position: 'left',
                        title: {
                            display: true,
                            text: 'Rata-rata Mood (1-10)'
                        },
                        min: 0,
                        max: 10
                    },
                    y1: {
                        type: 'linear',
                        display: true,
                        position: 'right',
                        title: {
                            display: true,
                            text: 'Jumlah Entri'
                        },
                        grid: {
                            drawOnChartArea: false
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart'
                }
            }
        };

        if (this.charts.weeklyProgress) {
            this.charts.weeklyProgress.destroy();
        }
        this.charts.weeklyProgress = new Chart(ctx, config);
    }

    getLast7DaysData(moodHistory) {
        const days = [];
        const intensities = [];
        const today = new Date();

        for (let i = 6; i >= 0; i--) {
            const date = new Date(today);
            date.setDate(date.getDate() - i);
            const dateString = date.toDateString();
            
            const dayEntries = moodHistory.filter(entry => entry.date === dateString);
            const avgIntensity = dayEntries.length > 0 
                ? dayEntries.reduce((sum, entry) => sum + entry.intensity, 0) / dayEntries.length
                : 0;
            
            days.push(date.toLocaleDateString('id-ID', { weekday: 'short' }));
            intensities.push(Math.round(avgIntensity * 10) / 10);
        }

        return { labels: days, intensities };
    }

    calculateNutritionData() {
        // Mock data based on typical daily intake
        // In a real app, this would be calculated from actual food consumption
        return [65, 300, 50, 25, 100]; // Protein, Carbs, Fat, Fiber, Vitamins
    }

    calculateMoodDistribution(moodHistory) {
        const distribution = {
            sedih: 0,
            senang: 0,
            marah: 0,
            cemas: 0,
            stress: 0,
            lelah: 0
        };

        moodHistory.forEach(entry => {
            if (distribution.hasOwnProperty(entry.mood)) {
                distribution[entry.mood]++;
            }
        });

        return distribution;
    }

    getWeeklyProgressData() {
        const moodHistory = this.getMoodHistory();
        const weeks = 4;
        const avgMood = [];
        const entryCount = [];

        for (let i = weeks - 1; i >= 0; i--) {
            const weekStart = new Date();
            weekStart.setDate(weekStart.getDate() - (i + 1) * 7);
            const weekEnd = new Date();
            weekEnd.setDate(weekEnd.getDate() - i * 7);

            const weekEntries = moodHistory.filter(entry => {
                const entryDate = new Date(entry.timestamp);
                return entryDate >= weekStart && entryDate < weekEnd;
            });

            const weekAvg = weekEntries.length > 0
                ? weekEntries.reduce((sum, entry) => sum + entry.intensity, 0) / weekEntries.length
                : 0;

            avgMood.push(Math.round(weekAvg * 10) / 10);
            entryCount.push(weekEntries.length);
        }

        return { avgMood, entryCount };
    }

    updateAllCharts() {
        this.createMoodTrendChart();
        this.createNutritionChart();
        this.createMoodDistributionChart();
        this.createWeeklyProgressChart();
    }

    // Method to export chart data
    exportChartData() {
        const moodHistory = this.getMoodHistory();
        return {
            moodTrend: this.getLast7DaysData(moodHistory),
            nutrition: this.calculateNutritionData(),
            moodDistribution: this.calculateMoodDistribution(moodHistory),
            weeklyProgress: this.getWeeklyProgressData(),
            exportDate: new Date().toISOString()
        };
    }

    // Method to resize charts (useful for responsive design)
    resizeCharts() {
        Object.values(this.charts).forEach(chart => {
            if (chart && typeof chart.resize === 'function') {
                chart.resize();
            }
        });
    }

    // Method to update chart colors (for theme switching)
    updateChartTheme(isDark = false) {
        const textColor = isDark ? '#fff' : '#333';
        const gridColor = isDark ? 'rgba(255,255,255,0.1)' : 'rgba(0,0,0,0.1)';

        Object.values(this.charts).forEach(chart => {
            if (chart && chart.options) {
                // Update text colors
                if (chart.options.scales) {
                    Object.values(chart.options.scales).forEach(scale => {
                        if (scale.ticks) scale.ticks.color = textColor;
                        if (scale.title) scale.title.color = textColor;
                        if (scale.grid) scale.grid.color = gridColor;
                    });
                }
                
                // Update plugin colors
                if (chart.options.plugins) {
                    if (chart.options.plugins.title) {
                        chart.options.plugins.title.color = textColor;
                    }
                    if (chart.options.plugins.legend && chart.options.plugins.legend.labels) {
                        chart.options.plugins.legend.labels.color = textColor;
                    }
                }
                
                chart.update();
            }
        });
    }
}

// Initialize charts manager only if not already initialized by main app
document.addEventListener('DOMContentLoaded', () => {
    if (!window.ChartsManager && !window.moodFoodApp) {
        // Wait for Chart.js to load
        if (typeof Chart !== 'undefined') {
            window.ChartsManager = new ChartsManager();
        } else {
            // Retry after a short delay if Chart.js is not loaded yet
            setTimeout(() => {
                if (typeof Chart !== 'undefined') {
                    window.ChartsManager = new ChartsManager();
                }
            }, 1000);
        }
    }
});

// Handle window resize for chart responsiveness
window.addEventListener('resize', () => {
    if (window.ChartsManager) {
        setTimeout(() => {
            window.ChartsManager.resizeCharts();
        }, 100);
    }
});

// Export for use in other modules
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ChartsManager;
}
