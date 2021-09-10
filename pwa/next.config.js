module.exports = {
  basePath: '/api',
  serverRuntimeConfig: {
    NEXT_PUBLIC_ENTRYPOINT: process.env.NEXT_PUBLIC_ENTRYPOINT || "http://localhost",
  },
};
