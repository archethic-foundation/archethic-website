import React from 'react'
import { Suspense } from 'react'
import { useBreakpoints } from '../utils/hooks/useBreakpoints.js'
import { Canvas } from '@react-three/fiber'
import {Particles} from "./ParticlesModels/ParticlesModels";
import {DnaModel} from "./DnaModel/DnaModel";

const Scene = () => {
  const { isScreenSmall } = useBreakpoints()

  return (
    <Canvas style={{ backgroundColor: 'hsl(250 100% 5% / 1)' }}>
      <ambientLight />
      <directionalLight color='white' position={[0, -113.0, 60.0]} />

      <Suspense fallback={null}>
        <DnaModel position={isScreenSmall ? [0.9, 1, 0] : [2, 0, 0]} scale={1.2} />
        <Particles size={isScreenSmall ? 100 : 400} />
      </Suspense>
    </Canvas>
  )
}

export default Scene
