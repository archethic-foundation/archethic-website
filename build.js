require("esbuild")
  .build({
    entryPoints: ["./bundle.js", "./bundle.css"],
    bundle: true,
    outdir: "dist",
    logLevel: "info",
    minify: true,
    treeShaking: true,
    splitting: true,
    format: 'esm'
  }).catch(() => process.exit(1));
