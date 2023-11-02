import { Suspense } from 'react'
import { DnaModel } from '@/canvas/DnaModel/DnaModel'
import { Particles } from '@/canvas/ParticlesModels/ParticlesModels'
import { useBreakpoints } from '@/utils/hooks/useBreakpoints'
import { Canvas } from '@react-three/fiber'

const Scene = () => {
  const { isScreenSmall } = useBreakpoints()

  return (
    <Canvas>
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
