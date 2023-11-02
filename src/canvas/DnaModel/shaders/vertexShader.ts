const vertexShader = `
uniform float time;
uniform float dotSize;
varying vec2 vUv;
varying vec3 vPosition;
varying float vColorRandom;
uniform sampler2D texture1;

attribute float randoms;
attribute float colorRandoms;

float PI = 3.141592653589793238;

void main() {
  vUv=uv;
  vColorRandom=colorRandoms;
  vec4 mvPosition=modelViewMatrix*vec4(position,1.);
  gl_PointSize=(dotSize * randoms+10.)*(1./-mvPosition.z);
  gl_Position=projectionMatrix*mvPosition;
}
`

export default vertexShader
