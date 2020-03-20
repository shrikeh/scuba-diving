"use strict";

import { Item } from "@app/types/Kit/Item";

export interface KitBag {
  getItemDetail(slug: string): Array<Item>
}
