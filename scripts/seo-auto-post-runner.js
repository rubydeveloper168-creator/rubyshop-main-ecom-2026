#!/usr/bin/env node

const { spawnSync } = require('node:child_process');

const appDir = process.env.SEO_APP_DIR || process.cwd();
const phpBin = process.env.PHP_BIN || 'php';
const count = process.env.SEO_AUTO_POST_COUNT || '1';
const dryRun = String(process.env.SEO_AUTO_POST_DRY_RUN || '').toLowerCase() === 'true';

const args = ['artisan', 'seo:auto-post', `--count=${count}`];

if (dryRun) {
  args.push('--dry-run');
}

const start = new Date();
console.log(`[seo-auto-post] start=${start.toISOString()} cwd=${appDir} php=${phpBin} args=${args.join(' ')}`);

const run = spawnSync(phpBin, args, {
  cwd: appDir,
  env: process.env,
  encoding: 'utf8',
});

if (run.stdout) {
  process.stdout.write(run.stdout);
}

if (run.stderr) {
  process.stderr.write(run.stderr);
}

if (run.error) {
  console.error(`[seo-auto-post] error=${run.error.message}`);
  process.exit(1);
}

if (run.status !== 0) {
  console.error(`[seo-auto-post] failed exitCode=${run.status}`);
  process.exit(run.status || 1);
}

console.log(`[seo-auto-post] done=${new Date().toISOString()}`);

