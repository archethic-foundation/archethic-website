export function clamp(min: number, input: number, max: number) {
  return Math.max(min, Math.min(input, max))
}

export function mapRange(
  in_min: number,
  in_max: number,
  input: number,
  out_min: number,
  out_max: number
) {
  return ((input - in_min) * (out_max - out_min)) / (in_max - in_min) + out_min
}

export function lerp(x: number, y: number, t: number) {
  return (1 - t) * x + t * y
}

export function truncate(value: number, decimals: number) {
  return parseFloat(value.toFixed(decimals))
}

export function findXPercentage(X: number, start: number, end: number) {
  if (X <= start) {
    return 0
  }

  if (X >= end) {
    return 100
  }

  return ((X - start) / (end - start)) * 100
}
