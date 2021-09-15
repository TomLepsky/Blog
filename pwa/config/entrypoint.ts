export const NEXT_PUBLIC_ENTRYPOINT = typeof window === "undefined" ? process.env.NEXT_PUBLIC_ENTRYPOINT : window.origin;
export const API_ENTRYPOINT = typeof window === "undefined" ? process.env.API_ENTRYPOINT : 'https://blog.feature.zone/api';
