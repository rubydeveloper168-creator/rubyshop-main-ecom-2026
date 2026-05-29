module.exports = {
  apps: [
    {
      name: 'seo-auto-post-schedule',
      script: './scripts/seo-auto-post-runner.js',
      cwd: '/var/www/rubyshop.co.th/rubyshop-main-ecom-2026',
      instances: 1,
      exec_mode: 'fork',
      autorestart: false,
      cron_restart: '0 8,13,18 * * *',
      time: true,
      merge_logs: true,
      out_file: '/var/www/rubyshop.co.th/rubyshop-main-ecom-2026/storage/logs/seo-auto-post-pm2.log',
      error_file: '/var/www/rubyshop.co.th/rubyshop-main-ecom-2026/storage/logs/seo-auto-post-pm2.log',
      env: {
        TZ: 'Asia/Bangkok',
        SEO_APP_DIR: '/var/www/rubyshop.co.th/rubyshop-main-ecom-2026',
        PHP_BIN: 'php',
        SEO_AUTO_POST_COUNT: '1',
      },
    },
  ],
};

