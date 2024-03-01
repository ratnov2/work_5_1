import { FC, ReactNode, createContext, useState } from "react";

const LIMIT = 50;
const OFFSET = 0;

export const PageInfoContext = createContext<IPageInfoContext>({
  offset: OFFSET,
  handleChangeOffset: () => {},
  limit: LIMIT,
  handleChangeLimit: () => {},
});

interface IPageInfoContextComponent {
  children: ReactNode;
}
interface IPageInfoContext {
  offset: number;
  handleChangeOffset: (offset: number) => void;
  limit: number;
  handleChangeLimit: (limit: number) => void;
}

export const PageInfoContextComponent: FC<IPageInfoContextComponent> = ({
  children,
}) => {
  const [offset, setOffset] = useState(OFFSET);
  const [limit, setLimit] = useState(LIMIT);
  const handleChangeLimit = (limit: number) => setLimit(limit);
  const handleChangeOffset = (offset: number) => setOffset(offset);
  return (
    <PageInfoContext.Provider
      value={{
        offset,
        handleChangeLimit,
        limit,
        handleChangeOffset,
      }}
    >
      {children}
    </PageInfoContext.Provider>
  );
};
