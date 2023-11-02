import { create } from 'zustand'

export type DevelopersPageSections = 'hero' | 'joinUs' | 'developerResources' | 'explore' | 'xx'

export type DevelopersPageStore = {
  sections?: Record<
    DevelopersPageSections,
    {
      offsetTop: number
      height: number
    }
  >
}

export type DevelopersPageAction = {
  updateSections: (sections: DevelopersPageStore['sections']) => void
}

export const useDevelopersPageStore = create<DevelopersPageStore & DevelopersPageAction>((set) => ({
  sections: undefined,
  updateSections: (sections) => set(() => ({ sections: sections })),
}))
