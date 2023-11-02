const fragmentShader = `
uniform float time;
uniform float progress;
uniform sampler2D texture1;
uniform vec4 resolution;
varying vec2 vUv;
varying vec3 vPosition;
varying float vColorRandom;

uniform vec3 uColor1;
uniform vec3 uColor2;
uniform vec3 uColor3;
uniform vec3 colorC;

float PI = 3.141592653589793238;

void main() {
  float alpha = 1. - smoothstep(-.2,.5,length(gl_PointCoord-vec2(.5)));

  vec3 finalColor=uColor1;
  if(vColorRandom > .33 && vColorRandom < .66){
    finalColor=uColor1;
  }
  
  if(vColorRandom > .66){
    finalColor=uColor2;
  }
  
  float gradient = smoothstep(.3,.7,vUv.y);

  // vec2 newUV = (vUv - vec2(0.5))*resolution.zw + vec2(0.5);
  // gl_FragColor=vec4(1.,1.,0.,alpha);
  gl_FragColor=vec4(finalColor,alpha*gradient);
}
`

export default fragmentShader
