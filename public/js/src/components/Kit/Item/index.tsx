"use strict";

import * as React from "react";

import { Item as ItemInterface } from "@app/types/Kit/Item";

export class Item extends React.Component<ItemInterface> {
  public render() {
    return (
        <div className="kit-item">
            Ohai, I am an item
        </div>
    );
  }
}
