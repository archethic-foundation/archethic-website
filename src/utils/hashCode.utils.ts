export function hashCode(value: string): number {
  let h = 0
  value = value.startsWith('#') ? value.substring(1) : value
  if (value?.length > 0) {
    for (let i = 0; i < value.length; i++) {
      h = 31 * h + value.codePointAt(i)!
    }
  }
  return h
}
